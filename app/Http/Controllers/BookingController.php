<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\BookingComment;
use App\Models\Clinic;
use App\Models\User;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Patient;
use App\Models\Rating;
use App\Models\Log;
use App\Models\Notification;
use App\Models\ClinicNotification;
use Illuminate\Support\Facades\Mail;
use DataTables;
use Carbon\Carbon;


//Validations
use App\Rules\AlphaSpace;
use App\Rules\PHNumber;
use App\Rules\Uppercase;
use App\Rules\URL;

class BookingController extends Controller
{
    //METHODS EXCLUSIVE FOR QUICK BOOKING
    public function quick_booking() { 
        $services = Service::paginate(5);
        return view('booking.quick', ['services' => $services]);
    }
    
    public function quick_booking_display(Service $service) {
        $start = Carbon::parse($service->serviceStart)->toDateTimeLocalString();
        $end = Carbon::parse($service->serviceEnd)->toDateTimeLocalString();

        $temp = Carbon::parse($service->serviceStart)->format('F j , Y  h:i A');
        $temp2 = Carbon::parse($service->serviceEnd)->format('F j , Y  h:i A');

        return view ('/booking/displayquick', ['service'=>$service, 'start'=>$start, 'end'=>$end
        ,'temp'=>$temp, 'temp2'=>$temp2]);
    }

    public function store_quick_booking(Request $request, $service) { 
        $user = auth()->user();
        $clinic = Service::where('id', $service)->get()->first();
    
        $clinics = Clinic::where('id', $clinic->clinic_id)->get()->first();
        $admin = User::where('id', $clinics->user_id)->get()->first();

        $record = Patient::where('user_id', $user->id)->where('clinic_id', $clinic->clinic_id)->get()->first();
        $vars = Service::find($service);

        request()->validate([
            'payment' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096',
        ]);

        
        if ($record == null) {
            $var = Patient::create([
                'user_id' => $user->id,
                'clinic_id' => $clinic->clinic_id,
                'created_at' => now(),
            ]);
        } else {
            $var = Patient::where('id', $record->id)->get()->first();
            $var->update([
                'updated_at' => now(),
            ]);
        }

        $var->save();

        if($request->hasfile('payment')) {
            $file = $request->file('payment');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('storage/bookingProof/', $filename);
        }

        if($request->has('consent')) {
            $temp = true;
        }else {
            $temp = false;
        }

        $start = Carbon::parse($request->start); //request
        $startValidate = Carbon::parse($request->start)->format('Y-m-d H:i:s'); //convert for comparator

        $var2 = $vars->serviceLength; //service length
        $totalDuration =  $start->addHours($var2)->format('Y-m-d H:i:s'); //add service length and request

        $startBookingAllowed = Carbon::parse($vars->serviceStart)->format('H:i:s');
        $endBookingAllowed = Carbon::parse($vars->serviceEnd)->format('H:i:s');
       
        $startBooking = Carbon::parse($request->start)->format('H:i:s');
        
        $patientBooking = Booking::where('user_id', $user->id)->whereIn('status', ['To Pay', 'In Progress'])->get();

        if ($startBookingAllowed > $startBooking){
            return redirect()->back()->with('message', 'Booking is outside the booking hours');
        }   

        if ($endBookingAllowed < $startBooking){
            return redirect()->back()->with('message', 'Booking is outside the booking hours');
        } 
        
        for ($i=0; $i < count($patientBooking); $i++) { 
            $patient = $patientBooking[$i];

            if ($patient['end'] >= $startValidate && $patient['start'] <= $totalDuration){
                return redirect()->back()->with('message', 'Booking overlaps with your other booking');
            } 
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'clinic_id' => $clinic->clinic_id,
            'patient_id' => $var->id,
            'service_id' => $service,
            'start' => request('start'),
            'end' => $totalDuration,
            'created' => now(),
            'consent' => $temp,
            'payment' => $filename,
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->clinic_id,
            'notifDescription' => $user->email . ' has booked an appointment for ' . 
                                $booking->start . " to " . $booking->end,
            'notifDateTime' => now(),
        ]);

        $detail = [ 
            'title' => "Mail from Mentalit-E",
            'body' => $user->email . ' has booked an appointment!',
        ];

        $to = $admin->email;
        
        Mail::to($to)->send(new \App\Mail\ClinicNotificationMail($detail));
    
        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => $user->email . ' has booked an appointment for ' . 
                                $booking->start . " to " . $booking->end,
            'notifDateTime' => now(),
        ]);

        $details = [ 
            'title' => "Mail from Mentalit-E",
            'body' => 'You have booked an appointment!',
        ];

        $tos = $user->email;
        
        Mail::to($tos)->send(new \App\Mail\NotificationMail($details));
    
        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic',
            'description' => $user->email . ' has booked an appointment for ' . 
                                $booking->start . " to " . $booking->end,
            'dateTime' => now(),
        ]);
 
        return redirect('/booking/patient/index')->with('message', 'Booking is successful');      
    }

    //METHODS EXCLUSIVE FOR MANUAL BOOKING
    public function index() { //display all clinic - manual booking
        $clinics = Clinic::where('clinicStatus', 1)->get();
        return view('booking.index', ['clinics' => $clinics]);
    }

    public function search(Request $request) {
        $query = $request->input('query');
        $searched_items = Clinic::where('clinicName', 'like', "%$query%")->
        orWhere('clinicAddress', 'like', "%$query%")->get();
        return view('/booking/search', ['searched_items'=>$searched_items]);
    }

    public function show(Clinic $clinic) { 
        $star = Rating::where('clinic_id', $clinic->id)->avg('starRating');
        $average = round($star, 2);
        $booking_count = Booking::where('clinic_id', $clinic->id)->where('status','Done')->count();
        $rating_count = Rating::where('clinic_id', $clinic->id)->count();
        $min = Service::where('clinic_id', $clinic->id)->min('servicePrice');
        $max = Service::where('clinic_id', $clinic->id)->max('servicePrice');
        $price = $min . " to " .  "₱" . $max ;
        return view ('booking.show', ['clinic'=>$clinic, 'average'=>$average, 
        'booking_count'=>$booking_count, 'rating_count'=>$rating_count
        , 'price'=>$price]);
    }

    public function view(Clinic $clinic) { 
        return view ('booking.view', ['clinic'=>$clinic]);
    }

    public function display(Clinic $clinic, Service $service) { 
        $user = auth()->user();
        $start = Carbon::parse($service->serviceStart)->toDateTimeLocalString();
        $end = Carbon::parse($service->serviceEnd)->toDateTimeLocalString();

        $temp = Carbon::parse($service->serviceStart)->format('F j , Y  h:i A');
        $temp2 = Carbon::parse($service->serviceEnd)->format('F j , Y  h:i A');

        return view ('booking.display', ['clinic'=>$clinic, 'service'=>$service, 'start'=>$start, 'end'=>$end
        ,'temp'=>$temp, 'temp2'=>$temp2]);
    }

    public function store_booking(Request $request, $clinic, $service) {
        $user = auth()->user();
        $clinic = Service::where('id', $service)->get('clinic_id')->first();

        $clinics = Clinic::where('id', $clinic->clinic_id)->get()->first();
        $admin = User::where('id', $clinics->user_id)->get()->first();

        $record = Patient::where('user_id', $user->id)->where('clinic_id', $clinic->clinic_id)->get()->first();
        $vars = Service::find($service);

        request()->validate([
            'payment' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096',
        ]);
        
        if ($record == null) {
            $var = Patient::create([
                'user_id' => $user->id,
                'clinic_id' => $clinic->clinic_id,
                'created_at' => now(),
            ]);
        } else {
            $var = Patient::where('id', $record->id)->get()->first();
            $var->update([
                'updated_at' => now(),
            ]);
        }

        $var->save();

        if($request->hasfile('payment')) {
            $file = $request->file('payment');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('storage/bookingProof/', $filename);
        }

        if($request->has('consent')) {
            $temp = true;
        }else {
            $temp = false;
        }

        $start = Carbon::parse($request->start); //request
        $startValidate = Carbon::parse($request->start)->format('Y-m-d H:i:s'); //convert for comparator

        $var2 = $vars->serviceLength; //service length
        $totalDuration =  $start->addHours($var2)->format('Y-m-d H:i:s'); //add service length and request

        $startBookingAllowed = Carbon::parse($vars->serviceStart)->format('H:i:s');
        $endBookingAllowed = Carbon::parse($vars->serviceEnd)->format('H:i:s');
       
        $startBooking = Carbon::parse($request->start)->format('H:i:s');

        $patientBooking = Booking::where('user_id', $user->id)->whereIn('status', ['To Pay', 'In Progress'])->get();

        if ($startBookingAllowed > $startBooking){
            return redirect()->back()->with('message', 'Booking is outside the booking hours');
        }   

        if ($endBookingAllowed < $startBooking){
            return redirect()->back()->with('message', 'Booking is outside the booking hours');
        } 
        
        for ($i=0; $i < count($patientBooking); $i++) { 
            $patient = $patientBooking[$i];

            if ($patient['end'] >= $startValidate && $patient['start'] <= $totalDuration){
                return redirect()->back()->with('message', 'Booking overlaps with your other booking');
            } 
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'clinic_id' => $clinic->clinic_id,
            'patient_id' => $var->id,
            'service_id' => $service,
            'start' => request('start'),
            'end' => $totalDuration,
            'created' => now(),
            'consent' => $temp,
            'payment' => $filename,
        ]); 

        ClinicNotification::create([
            'clinic_id' => $clinic->clinic_id,
            'notifDescription' => $user->email . ' has booked an appointment for ' . 
                                $booking->start . " to " . $booking->end,
            'notifDateTime' => now(),
        ]);

        $detail = [ 
            'title' => "Mail from Mentalit-E",
            'body' => $user->email . ' has booked an appointment!',
        ];

        $to = $admin->email;
        
        Mail::to($to)->send(new \App\Mail\ClinicNotificationMail($detail));
    
        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => $user->email . ' has booked an appointment for ' . 
                                $booking->start . " to " . $booking->end,
            'notifDateTime' => now(),
        ]);

        $details = [ 
            'title' => "Mail from Mentalit-E",
            'body' => 'You have booked an appointment!',
        ];

        $tos = $user->email;
        
        Mail::to($tos)->send(new \App\Mail\NotificationMail($details));
    
        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic',
            'description' => $user->email . ' has booked an appointment for ' . 
                                $booking->start . " to " . $booking->end,
            'dateTime' => now(),
        ]);

        return redirect('/booking/patient/index')->with('message', 'Booking is successful');
    }

    //METHODS EXCLUSIVE FOR CLINIC ADMIN
    public function display_booking_clinic (Booking $bookings, Clinic $clinic) { 
        $user = auth()->user(); 
        $var = Employee::where('user_id', $user->id)->get()->first();
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();
        $service = Service::where('clinic_id', $var->clinic_id)->get();
        $patient = Patient::where('clinic_id', $var->clinic_id)->get();
        $employee = Employee::where('clinic_id', $var->clinic_id)->get();
        return view ('/clinic/booking/index', ['clinic'=>$clinic, 'service'=>$service, 'patient'=>$patient, 'employee'=>$employee]);
    }    

    public function getBooking(Request $request, Booking $booking) {
        $user = auth()->user();
        $var = Employee::where('user_id', $user->id)->get()->first(); 
        $service = Service::where('clinic_id', $var->clinic_id)->get();
        $patient = Patient::where('clinic_id', $var->clinic_id)->get();
        $employee = Employee::where('clinic_id', $var->clinic_id)->get();
//
        if ($request->ajax()) {
            $data = Booking::where('clinic_id', $var->clinic_id)
            ->orderBy('status', 'desc')
            ->with(['userBooking', 'serviceBooking', 'employeeBooking']);
            return Datatables::eloquent($data)
                ->addIndexColumn()  
                ->addColumn('actions', 'clinic.booking.action')
                ->editColumn('payment', 'clinic.booking.payment')
                ->editColumn('link', 'clinic.booking.link')
                ->rawColumns(['actions', 'payment', 'link'])
                ->addColumn('userBooking', function(Booking $booking){
                    return $booking->userBooking->email;
                })
                ->addColumn('serviceBooking', function(Booking $booking){
                    return $booking->serviceBooking->serviceName;
                })
                ->addColumn('employeeBooking', function(Booking $booking){
                    if ($booking->employee_id == null) return "None";
                    else return $booking->employeeBooking->userEmployee->lastName . " , "
                    .$booking->employeeBooking->userEmployee->firstName . " " . 
                    $booking->employeeBooking->userEmployee->middleName ;
                })
                ->editColumn('bookingDate', function($row){
                    return Carbon::parse($row->start)->format('F j , Y  h:i A') . 
                    ' to ' .
                    Carbon::parse($row->end)->format('F j , Y  h:i A');
                })
                ->editColumn('created', function($row){
                    return Carbon::parse($row->created)->format('F j , Y  h:i A');
                })
                ->setRowId(function ($booking) { return $booking->id; })
                ->toJson();
        }

        return view ('/clinic/booking/index', ['service'=>$service, 'patient'=>$patient, 'employee'=>$employee]);
    }

    public function edit_link(Clinic $clinic, $id) { 
        $user = auth()->user(); 
        $booking = Booking::find($id); 
        $var = Employee::where('user_id', $user->id)->get()->first(); 
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first(); 
        return view ('/clinic/booking.editlink', ['clinic'=>$clinic, 'booking'=>$booking]);
    }    

    public function update_link(Request $request, $id) {
        $var = Booking::find($id);
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();
        $user = User::where('id', $var->user_id)->get()->first();

        request()->validate([
            'link' => ['required', new URL]
        ]);

        $var->update([
            'link' => request('link'),
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->id,
            'notifDescription' => 'The appointment for' . $user->email . 'link has been updated',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Your appointment at' . $clinic->clinicName . 'link has been updated',
            'notifDateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic',
            'description' => $user->email . ' appointment link has been updated by ' . 
                        $clinic->clinicName,
            'dateTime' => now(),
        ]);

        return redirect('/clinic/booking/index')->with('message', 'Link has been updated!');
    } 
    
    public function booking_details(Clinic $clinic, $id) { 
        $user = auth()->user(); 
        $booking = Booking::find($id); 
        $var = Employee::where('user_id', $user->id)->get()->first(); 
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first(); 
        $record = BookingComment::where('booking_id', $id)->get()->first();
        $rating = Rating::where('booking_id', $id)->get()->first();

        $temp = Carbon::parse($booking->start)->format('F j , Y  h:i A');
        $temp2 = Carbon::parse($booking->end)->format('F j , Y  h:i A');

        return view ('/clinic/booking.display', ['clinic'=>$clinic, 'booking'=>$booking, 'record'=>$record, 'rating'=>$rating
        , 'temp'=>$temp, 'temp2'=>$temp2]);
    }

    public function cancel_request($id) {  
        $user = auth()->user(); 
        $booking = Booking::find($id); 
        $var = Employee::where('user_id', $user->id)->get()->first(); 
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first(); 
        $record = BookingComment::where('booking_id', $id)->get()->first();
        $rating = Rating::where('booking_id', $id)->get()->first();

        $temp = Carbon::parse($booking->start)->format('F j , Y  h:i A');
        $temp2 = Carbon::parse($booking->end)->format('F j , Y  h:i A');

        return view ('/clinic/booking.cancel', ['clinic'=>$clinic, 'booking'=>$booking, 'record'=>$record, 'rating'=>$rating
        , 'temp'=>$temp, 'temp2'=>$temp2]);
    }

    public function cancel_booking(Request $request, $id) {  
        $var = Booking::find($id); 
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();
        $user = User::where('id', $var->user_id)->get()->first();

        $admin = User::where('id', $clinic->user_id)->get()->first();
        



        $var->delete();

        ClinicNotification::create([
            'clinic_id' => $var->clinic_id,
            'notifDescription' => 'The appointment for' . $user->email . 'has been cancelled due to '
            . $request->reason,
            'notifDateTime' => now(),
        ]);

        $detail = [ 
            'title' => "Mail from Mentalit-E",
            'body' => $user->email . ' booking has been cancelled due to ' . $request->reason,
        ];

        $to = $admin->email;
        
        Mail::to($to)->send(new \App\Mail\ClinicNotificationMail($detail));

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Your booking at' . $clinic->clinicName . 'has been cancelled 
            due to ' . $request->reason,
            'notifDateTime' => now(),
        ]);

        $details = [ 
            'title' => "Mail from Mentalit-E",
            'body' => 'Your booking at ' . $clinic->clinicName . ' has been cancelled
            due to ' . $request->reason,
        ];

        $tos = $user->email;
        
        Mail::to($tos)->send(new \App\Mail\NotificationMail($details));

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic',
            'description' => $user->email . ' appointment has been cancelled by ' . 
                        $clinic->clinicName,
            'dateTime' => now(),
        ]);

        return redirect('/clinic/booking/index')->with('negative', 'Booking has been declined and the user will be notified');
    }

    public function assign_booking(Clinic $clinic, $id) { //display available employees
        $user = auth()->user(); 
        $booking = Booking::find($id); 
        $var = Employee::where('user_id', $user->id)->get()->first(); 
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first(); 
        $temp = Employee::where('clinic_id', $var->clinic_id)->where('accountStatus', 'Active')->get();
        return view ('/clinic/booking.view', ['clinic'=>$clinic, 'booking'=>$booking, 'temp'=>$temp]);
    }

    public function update_first_booking(Request $request, $id, Employee $employee) { //assinging of consultation (step 2) - In Progress
        $var = Booking::find($id);
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();
        $user = User::where('id', $var->user_id)->get()->first();

        $employeeBooking = Booking::where('employee_id', $employee->id)->where('status', 'In Progress')->get();
      
        for ($i=0; $i < count($employeeBooking); $i++) { 
            $temp = $employeeBooking[$i];

            if ($temp['end'] >= $var->start && $temp['start'] <= $var->end){
                return redirect()->back()->with('negative', 'Booking overlaps with other booking of the employee');
            } 
        }

        $var->update([
            'employee_id' => $employee->id,
            'status' => 'In Progress',
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->id,
            'notifDescription' => 'The appointment for' . $user->email . 'has been updated',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Your appointment at' . $clinic->clinicName . 'has been updated',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $employee->user_id,
            'notifDescription' => 'Your have been assigned an appointment for ' . $user->email,
            'notifDateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic',
            'description' => $user->email . ' has been updated by ' . 
                        $clinic->clinicName,
            'dateTime' => now(),
        ]);

        return redirect('/clinic/booking/index')->with('message', 'Booking has been assigned to the employee');
    }

    //METHODS EXLUCSIVE FOR CLINIC EMPLOYEE

    public function display_booking_employee(Booking $bookings) { //display booking for assigned employee
        $user = auth()->user();
        return view('/booking/employee/index', ['user'=>$user]);
    }    

    public function getBookingEmployee(Request $request) {
        $user = auth()->user();
        $var = Employee::where('user_id', $user->id)->get()->first(); 

        if(empty($request)) {
            return 'No clinics yet!';
        } else {
            if ($request->ajax()) {
                $data = Booking::where('employee_id', $var->id)->where('status', 'In Progress')->with(['userBooking', 'serviceBooking']);
                return Datatables::eloquent($data)
                ->addIndexColumn()  
                ->addColumn('actions', 'booking.employee.action')
                ->editColumn('link', 'booking.employee.link')
                ->rawColumns(['actions', 'link'])
                ->addColumn('userBooking', function(Booking $booking){
                    return $booking->userBooking->lastName . " , " . $booking->userBooking->firstName
                    . " " . $booking->userBooking->middleName;
                })
                ->addColumn('serviceBooking', function(Booking $booking){
                    return $booking->serviceBooking->serviceName;
                })
                ->editColumn('bookingDate', function($row){
                    return Carbon::parse($row->start)->format('F j , Y  h:i A') . 
                    ' to ' .
                    Carbon::parse($row->end)->format('F j , Y  h:i A');
                })
                ->setRowId(function ($booking) { return $booking->id; })
                ->toJson();
            }  
        }

    } 
    
    public function edit_link_employee(Clinic $clinic, $id) { 
        $user = auth()->user(); 
        $booking = Booking::find($id); 
        $var = Employee::where('user_id', $user->id)->get()->first(); 
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first(); 
        return view ('/booking/employee.editlink', ['clinic'=>$clinic, 'booking'=>$booking, 'user'=>$user]);
    }    

    public function update_link_employee(Request $request, $id) {

        $var = Booking::find($id);
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();
        $user = User::where('id', $var->user_id)->get()->first();

        request()->validate([
            'link' => ['required', new URL]
        ]);

        $var->update([
            'link' => request('link'),
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->id,
            'notifDescription' => 'The appointment for' . $user->email . 'link has been updated',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Your appointment at' . $clinic->clinicName . 'link has been updated',
            'notifDateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic',
            'description' => $user->email . ' appointment link has been updated by ' . 
                        $clinic->clinicName,
            'dateTime' => now(),
        ]);

        return redirect('/booking/employee/index')->with('message', 'Link has been updated!');
    } 

    public function booking_employee_details(Clinic $clinic, $id) { 
        $user = auth()->user(); 
        $booking = Booking::find($id); 
        $record = BookingComment::where('booking_id', $id)->get()->first();

        $temp = Carbon::parse($booking->start)->format('F j , Y  h:i A');
        $temp2 = Carbon::parse($booking->end)->format('F j , Y  h:i A');

        return view ('/booking/employee.display', ['user'=>$user, 'booking'=>$booking, 'record'=>$record
        , 'temp'=>$temp, 'temp2'=>$temp2]);
    }

    public function display_patient_records(Booking $booking) {
        $user = auth()->user();
        $var = Booking::where('id', $booking->id)->get()->first();
        $record = Patient::where('id', $var->patient_id)->where('clinic_id', $booking->clinic_id)->get()->first();

        $temp = Carbon::parse($record->created_at)->format('F j , Y');

        return view('/record/show', ['record'=>$record, 'user'=>$user, 'booking'=>$booking
        , 'temp'=>$temp]);
    } 
    
    public function update_patient_records(Request $request, $record) {
        $var = Booking::find($record);
        $patient = Patient::where('id', $var->patient_id)->get()->first();
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();
        $user = User::where('id', $var->user_id)->get()->first();

        request()->validate([
            'emergencyName' => ['required', 'min:2', new AlphaSpace],
            'emergencyNumber' => ['required', 'max:13', new PHNumber], 
            'emergencyAddress' => ['required', 'min:10', 'max:255'],
            'familyHistory' => ['required', 'min:0', 'max:255'],
            'socialHistory' => ['required', 'min:0', 'max:255'],
            'medicalHistory' => ['required', 'min:0', 'max:255'],
            'currentMentalState' => ['required', 'min:0', 'max:255'],
            'currentMedicalTreatment' => ['required', 'min:0', 'max:255'],
        ]);

        $patient->update([
            'emergencyName' => request('emergencyName'),
            'emergencyNumber' => request('emergencyNumber'),
            'emergencyAddress' => request('emergencyAddress'),
            'familyHistory' => request('familyHistory'),
            'socialHistory' => request('socialHistory'),
            'medicalHistory' => request('medicalHistory'),
            'currentMentalState' => request('currentMentalState'),
            'currentMedicalTreatment' => request('currentMedicalTreatment'),
            'updated_at' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->id,
            'notifDescription' => 'The patient record of ' . $user->email . 'has been updated',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Your patient record at' . $clinic->clinicName . 'has been updated',
            'notifDateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic',
            'description' => $user->email . ' patient record has been updated by ' . 
                        $clinic->clinicName,
            'dateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Patient record has been updated!');
    }

    public function display_patient_history(Booking $booking) {
        $user = auth()->user();
        $var = Booking::where('id', $booking->id)->get()->first();
        $record = Patient::where('id', $var->patient_id)->where('clinic_id', $booking->clinic_id)->get()->first();
        return view('/record/history', ['record'=>$record, 'user'=>$user, 'booking'=>$booking]);
    }

    public function create_booking_remarks(Clinic $clinic, $id) { 
        $user = auth()->user(); 
        $booking = Booking::find($id); 
        $record = BookingComment::where('booking_id', $id)->get()->first();

        $temp = Carbon::parse($booking->start)->format('F j , Y  h:i A');
        $temp2 = Carbon::parse($booking->end)->format('F j , Y  h:i A');

        return view ('/booking/employee.remarks', ['user'=>$user, 'booking'=>$booking, 'record'=>$record
        , 'temp'=>$temp, 'temp2'=>$temp2]);
    }

    public function store_booking_remarks(Request $request, $id) {
    
        $var = Booking::find($id);
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();
        $user = User::where('id', $var->user_id)->get()->first();

        request()->validate([
            'referTo' => ['required', 'min:10', 'max:255'],
            'reason' => ['required', 'min:10', 'max:255'],
            'diagnosis' => ['required', 'min:10', 'max:255'],
            'fileUpload' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096',
        ]);

        if($request->hasfile('fileUpload')) {
            $file = $request->file('fileUpload');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('storage/bookingRemarks/', $filename);
        }

        if($request->has('permission')) {
            $temp = true;
        } else {
            $temp = false;
        }

        BookingComment::create([
            'booking_id' => $var->id,
            'referTo' => request('referTo'),
            'reason' => request('reason'),
            'diagnosis' => request('diagnosis'),
            'permission' => $temp,
            'fileUpload' => $filename,
            'dateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->id,
            'notifDescription' => 'The booking of ' . $user->email . 'is done and waiting for ratings',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Your booking at' . $clinic->clinicName . 'is done and waiting for ratings',
            'notifDateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic',
            'description' => $user->email . ' booking is done and waiting for ratings of ' . 
                        $clinic->clinicName,
            'dateTime' => now(),
        ]);

        $var->update([
            'status' => 'To Rate',
        ]);

        return redirect('/booking/employee/index')->with('message', 'Remarks has been submitted!');
    } 

    //METHODS EXCLUSIVE FOR PATIENTS
    public function display_booking_patient(Booking $bookings) { //display all booking of the patient
        $user = auth()->user();
        $clinic = Patient::where('user_id', $user->id)->get();
        return view ('/booking/patient/index', ['user'=>$user, 'clinic'=>$clinic]);
    }

    public function getBookingPatient(Request $request, Booking $booking) {
        $user = auth()->user();

   

        if ($request->ajax()) {
            $data = Booking::where('user_id', $user->id)
            ->orderBy('status', 'desc')
            ->with([ 'clinicBooking' ,'serviceBooking']);
            return Datatables::eloquent($data)
                ->addIndexColumn()  
                ->addColumn('actions', 'booking.patient.action')
                ->editColumn('link', 'booking.patient.link')
                ->rawColumns(['actions', 'link'])
                ->addColumn('clinicBooking', function(Booking $booking){
                    return $booking->clinicBooking->clinicName;
                })
                ->addColumn('serviceBooking', function(Booking $booking){
                    return $booking->serviceBooking->serviceName;
                })
                ->editColumn('bookingDate', function($row){
                    return Carbon::parse($row->start)->format('F j , Y  h:i A') . 
                    ' to ' .
                    Carbon::parse($row->end)->format('F j , Y  h:i A');
                })
                ->toJson();
        }
    }        

    public function view_booking_details($id) {
        $user = auth()->user();
        $booking = Booking::find($id);
        $record = BookingComment::where('booking_id', $booking->id)->get()->first();

        $temp = Carbon::parse($booking->start)->format('F j , Y  h:i A');
        $temp2 = Carbon::parse($booking->end)->format('F j , Y  h:i A');
  
   
        return view ('/booking/patient/view', ['user'=>$user, 'booking'=>$booking, 'record'=>$record, 'temp'=>$temp, 'temp2'=>$temp2]);
    }

    public function create_booking_ratings(Clinic $clinic, $id) { 
        $user = auth()->user(); 
        $booking = Booking::find($id); 

        $temp = Carbon::parse($booking->start)->format('F j , Y  h:i A');
        $temp2 = Carbon::parse($booking->end)->format('F j , Y  h:i A');

        return view ('/booking/patient/ratings', ['user'=>$user, 'booking'=>$booking, 'temp'=>$temp, 'temp2'=>$temp2]);
    }

    public function store_booking_ratings(Request $request, $id) {
        $user = auth()->user();
        $var = Booking::find($id);
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();

        request()->validate([
            'ratingDescription' => ['required', 'min:10', 'max:255'],
            'starRating' => 'required',
        ]);

        Rating::create([
            'user_id' => $user->id,
            'clinic_id' => $var->clinic_id,
            'booking_id' => $var->id,
            'starRating' => request('starRating'),
            'ratingDescription' => request('ratingDescription'),
            'dateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->id,
            'notifDescription' => 'The booking of ' . $user->email . 'has been rated',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Your booking at' . $clinic->clinicName . 'has been rated',
            'notifDateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic',
            'description' => $user->email . ' booking has been rated for ' . 
                        $clinic->clinicName,
            'dateTime' => now(),
        ]);

        $var->update([
            'status' => 'Done',
        ]);

        return redirect('/booking/patient/index')->with('message', 'Ratings has been submitted!');
    } 

    public function booking_patient_cancel(Clinic $clinic, $id) { 
        $user = auth()->user(); 
        $booking = Booking::find($id); 

        $temp = Carbon::parse($booking->start)->format('F j , Y  h:i A');
        $temp2 = Carbon::parse($booking->end)->format('F j , Y  h:i A');

        return view ('/booking/patient/cancel', ['user'=>$user, 'booking'=>$booking, 'temp'=>$temp, 'temp2'=>$temp2]);
    }    

    public function cancel_booking_patient(Request $request, $id) {
        $user = auth()->user();
        $var = Booking::find($id);
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();

        request()->validate([
            'reason' => ['required', 'min:10', 'max:255'],
        ]);

        $var->update([
            'reason' => request('reason'),
            'status' => 'To Cancel',
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->id,
            'notifDescription' => 'The booking of ' . $user->email . 'has filed for cancellation',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Your booking at' . $clinic->clinicName . 'has filed for cancellation',
            'notifDateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic',
            'description' => $user->email . ' booking has filed for cancellation for ' . 
                        $clinic->clinicName,
            'dateTime' => now(),
        ]);

        return redirect('/booking/patient/index')->with('message', 'File for Cancellation has been submitted!');
    }     
    
    
    


  









}
