<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use DataTables;
use App\Models\Clinic;
use App\Models\User;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\Log;
use App\Models\Notification;
use App\Models\ClinicNotification;
use App\Models\Rating;
use Carbon\Carbon;

//Validation Rules
use App\Rules\AlphaSpace;
use App\Rules\PHNumber;
use App\Rules\Uppercase;




class ClinicController extends Controller
{

    public function create(Subscription $subscriptions) { //create new clinic
        $subscriptions = Subscription::all();
        $user = auth()->user();
        $clinic = Clinic::where('user_id', $user->id)->get()->first();
        if ($clinic != null) {
            abort(420);
        }
        return view ('/clinic/clinic/create', ['subscriptions'=>$subscriptions]);
    }
    
    public function store(Request $request) { //store new clinic
        
        $user = auth()->user();

        $temp = Clinic::where('user_id', $user->id)->get()->first();

        if ($temp != null) {
            abort(420);
        }
        
        request()->validate([
            'subscription_id' => 'required',
            'clinicName' => ['required', 'min:2', 'max:30', new AlphaSpace],
            'clinicDescription' => ['required', 'min:10', 'max:255'],
            'clinicAddress' => ['required', 'min:10', 'max:255'],
            'clinicNumber' => ['required', 'max:13', new PHNumber],
            'birLicenseExpiry' => ['required', 'date', 'after:today'],

            'birLicense' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096', 
            'prcLicense' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096', 
            'paymentProof' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096', 
        ]);

        if($request->hasfile('birLicense')) {
            $fileBIR = $request->file('birLicense');
            $extensionBIR = $fileBIR->getClientOriginalExtension();
            $filenameBIR = time().'.'.$extensionBIR;
            $fileBIR->move('storage/clinicBIR/', $filenameBIR);
        }

        if($request->hasfile('prcLicense')) {
            $filePRC = $request->file('prcLicense');
            $extensionPRC = $filePRC->getClientOriginalExtension();
            $filenamePRC = time().'.'.$extensionPRC;
            $filePRC->move('storage/prcLicense/', $filenamePRC);
        }

        if($request->hasfile('paymentProof')) {
            $filePayment = $request->file('paymentProof');
            $extensionPayment = $filePayment->getClientOriginalExtension();
            $filenamePayment = time().'.'.$extensionPayment;
            $filePayment->move('storage/paymentProof/', $filenamePayment);
        }
        
        $clinic = Clinic::create([
            'user_id' => $user->id,
            'clinicName' => request('clinicName'),
            'clinicDescription' => request('clinicDescription'),
            'clinicAddress' => request('clinicAddress'),
            'clinicNumber' => request('clinicNumber'),
            'birLicense' => $filenameBIR,
            'birLicenseExpiry' => request('birLicenseExpiry'),
        ]);

        $clinic->save();

        Employee::create([
            'user_id' => $user->id,
            'clinic_id' => $clinic->id,
            'prcLicense' => $filenamePRC, 
            'accountStatus' => 'Inactive'
        ]);

        Payment::create([
            'user_id' => $user->id,
            'clinic_id' => $clinic->id,
            'paymentProof' => $filenamePayment,
            'subscription_id' => request('subscription_id'),
            'paymentDateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . 'is waiting for approval of  ' .$clinic->clinicName. ' attached with BIR License',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Own clinic is waiting for approval of the System Administrator',
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->id,
            'notifDescription' => 'Own clinic is waiting for approval of the System Administrator',
            'notifDateTime' => now(),
        ]);
        
        return redirect ('/clinic/clinic/single');
    }

    public function single(Clinic $clinic, Subscription $subscriptions) { //view own clinic
        $user = auth()->user(); 
        $var = Employee::where('user_id', $user->id)->get()->first();
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();
        $star = Rating::where('clinic_id', $var->clinic_id)->avg('starRating');
        $average = round($star, 2);
        
        return view ('/clinic/clinic/single', ['clinic' => $clinic, 'average'=>$average]); 
    }

    public function resubscribe() {
        $subscriptions = Subscription::all();
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->get()->first();
        $clinic = Clinic::where('user_id', $user->id)->get()->first();
        $payment = Payment::where('user_id', $user->id)->where('paymentStatus', 'Pending')->get()->first();
        if ($payment != null) {
            abort(421);
        }
        return view ('/resubscribe', ['subscriptions'=>$subscriptions, 'clinic'=>$clinic]);
    }

    public function store_resubscribe(Request $request) {
        $user = auth()->user();
        $clinic = Clinic::where('user_id', $user->id)->get()->first();

        request()->validate([
            'subscription_id' => 'required',
            'paymentProof' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096', 
        ]);

        if($request->hasfile('paymentProof')) {
            $filePayment = $request->file('paymentProof');
            $extensionPayment = $filePayment->getClientOriginalExtension();
            $filenamePayment = time().'.'.$extensionPayment;
            $filePayment->move('storage/paymentProof/', $filenamePayment);
        }      

        Payment::create([
            'user_id' => $user->id,
            'clinic_id' => $clinic->id,
            'paymentProof' => $filenamePayment,
            'subscription_id' => request('subscription_id'),
            'paymentDateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . 'is waiting for payment approval of  ' . $clinic->clinicName. ' subscription',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Own clinic subscription is waiting for payment approval of the System Administrator',
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->id,
            'notifDescription' => 'Own clinic subscription is waiting for payment approval of the System Administrator',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Payment for the renewal of subscription has been uploaded successfully!');
    }

    public function edit(Clinic $clinic) { //edit own clinic
        $user = auth()->user();
        $var = Employee::where('user_id', $user->id)->get()->first();
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();
        $subscriptions = Subscription::all();

        return view ('/clinic/clinic/edit', ['clinic'=>$clinic , 'subscriptions' => $subscriptions]);
    }  
    
    public function update_info(Request $request, Clinic $clinic) { //update general info clinic
        $user = auth()->user();
        $var = Clinic::where('id', $clinic->id)->get()->first();

        request()->validate([
            'clinicName' => ['required', 'min:2', 'max:30', new AlphaSpace],
            'clinicDescription' => ['required', 'min:10', 'max:255'],
            'clinicAddress' => ['required', 'min:10', 'max:255'],
            'clinicNumber' => ['required', 'max:13', new PHNumber],
        ]);

        $var->update([
            'clinicName' => request('clinicName'),
            'clinicDescription' => request('clinicDescription'),
            'clinicAddress' => request('clinicAddress'),
            'clinicNumber' => request('clinicNumber'),                        
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has updated the information of ' . $var->clinicName,
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Own clinic information has been updated',
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $var->id,
            'notifDescription' => 'Own clinic information has been updated',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Clinic information updated successfully!');;
    }    

    public function update_picture(Request $request, Clinic $clinic) { //update picture clinic
        $var = Clinic::where('id', $clinic->id)->get()->first();
        $user = User::where('id', $var->user_id)->get()->first();

        request()->validate([
            'clinicMainPhoto' => 'mimes:jpg,jpeg,png|max:4096',                                                             
        ]);

        if($request->hasFile('clinicMainPhoto')) {
            $destination = 'storage/avatars/'.$var->clinicMainPhoto;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $file = $request->file('clinicMainPhoto');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('storage/avatars/', $filename);
            $var->clinicMainPhoto = $filename;
        }

        $var->update();

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has updated the information of ' . $var->clinicName,
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Own clinic information has been updated',
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $var->id,
            'notifDescription' => 'Own clinic information has been updated',
            'notifDateTime' => now(),
        ]);
 
        return redirect()->back()->with('message', 'Profile Image for the clinic has been updated!');
    }     

    public function update_payment(Request $request, Clinic $clinic) { //update payment info
        $var = Clinic::where('id', $clinic->id)->get()->first();
        $user = User::where('id', $var->user_id)->get()->first();

        request()->validate([
            'clinicPaymentInfo' => ['required', 'min:10', 'max:255'],
        ]); 

        $var->update([
            'clinicPaymentInfo' => request('clinicPaymentInfo'),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has updated the information of ' . $var->clinicName,
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Own clinic information has been updated',
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $var->id,
            'notifDescription' => 'Own clinic information has been updated',
            'notifDateTime' => now(),
        ]);
 
        return redirect()->back()->with('message', 'Payment Information for the clinic has been updated!');
    }
    
    public function update_license(Request $request, Clinic $clinic) { //update clinic bir license
        $user = auth()->user();
        $var = Clinic::where('id', $clinic->id)->get()->first();

        request()->validate([
            'birLicenseExpiry' => ['required', 'date', 'after:today'],
            'birLicense' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096',   
        ]);

        if($request->hasFile('birLicense')) {
            $destination = 'storage/clinicBIR/'.$var->birLicense;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $file = $request->file('birLicense');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('storage/clinicBIR/', $filename);
        }

        $var->update([
            'birLicenseExpiry' => request('birLicenseExpiry'),
            'birLicense' => $filename,
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has updated the BIR LICENSE of with new file ' . $var->clinicName,
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Own clinic information has been updated',
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $var->id,
            'notifDescription' => 'Own clinic information has been updated',
            'notifDateTime' => now(),
        ]);
 
        return redirect()->back()->with('message', 'BIR License for the clinic has been updated and the System Administrator will be notified!');
    }  

    public function update_subscription(Request $request, Clinic $clinic) { //update clinic subscription
        $user = auth()->user();
        $var = Clinic::where('id', $clinic->id)->get()->first();

        request()->validate([
            'subscription_id' => 'required',
            'paymentProof' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096', 
        ]);

        if($request->hasfile('paymentProof')) {
            $filePayment = $request->file('paymentProof');
            $extensionPayment = $filePayment->getClientOriginalExtension();
            $filenamePayment = time().'.'.$extensionPayment;
            $filePayment->move('storage/paymentProof/', $filenamePayment);
        }      

        Payment::create([
            'user_id' => $user->id,
            'clinic_id' => $clinic->id,
            'paymentProof' => $filenamePayment,
            'subscription_id' => request('subscription_id'),
            'paymentDateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has availed new subscription for ' . $clinic->clinicName,
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Own clinic has availed new subscription',
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $var->id,
            'notifDescription' => 'Own clinic has availed new subscription',
            'notifDateTime' => now(),
        ]);
 
        return redirect()->back()->with('message', 'Payment for the renewal of subscription has been uploaded successfully!');
    }      

    public function display_employee(Clinic $clinic) {
        $user = auth()->user(); //get logged in user
        $var = Employee::where('user_id', $user->id)->get()->first(); 
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first(); //get the clinic id of the logged in user
        $employee = Employee::where('clinic_id', $var->clinic_id)->get();
        return view ('/clinic/employee/index', ['clinic'=>$clinic, 'employee'=>$employee]); //return results
    }
    
    public function getEmployee(Request $request, Employee $employee) {
        $user = auth()->user();
        $var = Employee::where('user_id', $user->id)->get()->first(); 

        if ($request->ajax()) {
            $data = Employee::where('clinic_id', $var->clinic_id)->with('userEmployee');
            return Datatables::eloquent($data)
                ->addIndexColumn()  
                ->addColumn('actions', 'clinic.employee.action')
                ->editColumn('link', 'clinic.employee.link')
                ->editColumn('accountStatus', 'clinic.employee.status')
                ->rawColumns(['actions', 'link', 'status'])
                ->addColumn('userName', function(Employee $employee){
                    return $employee->userEmployee->lastName . " , " . $employee->userEmployee->firstName
                    . " " . $employee->userEmployee->middleName;
                })
                ->addColumn('userEmployee', function(Employee $employee){
                    return $employee->userEmployee->userType;
                })                
                ->setRowId(function ($employee) { return $employee->id; })
                ->toJson();
        }
    }  

    public function accept_employee(Request $request, $id) {
        $user = auth()->user();
        $employee = Employee::find($id);
        $var = Clinic::where('user_id', $user->id)->get()->first();
        
        $employee->update([
            'accountStatus'=>'Inactive',
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has accepted an employee for ' . $var->clinicName,
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Own clinic has accepted an employee',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $employee->user_id,
            'notifDescription' => 'You have been accepted as an employee of ' . $var->clinicName,
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $var->id,
            'notifDescription' => 'Own clinic has accepted an employee',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Employee has been accepted and the user will be notified.');
    }

    public function decline_employee(Request $request, $id) {
        $user = auth()->user();
        $employee = Employee::find($id);
        $var = Clinic::where('user_id', $user->id)->get()->first();
        
        $employee->delete();

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has declined an employee for ' . $var->clinicName,
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Own clinic has declined an employee',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $employee->user_id,
            'notifDescription' => 'You have been declined as an employee of ' . $var->clinicName,
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $var->id,
            'notifDescription' => 'Own clinic has declined an employee',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Employee has been declined and the user will be notified.');
    }
    
    public function update_employee(Request $request, $id) {
        $user = auth()->user();
        $employee = Employee::find($id);

        $var = Clinic::where('user_id', $user->id)->get()->first();

        if ($user->id == $employee->user_id){
            abort(403);
        } 

        if($employee->accountStatus == "Active") {
            $employee->accountStatus = "Inactive";
            $message = "Employee has been deactivated";
        } else {
            $employee->accountStatus = "Active";    
            $message = "Employee has been activated";
        }

        $employee->save();

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has updated an employee with a status of  ' 
            . $employee->accountStatus. ' from ' . $var->clinicName,
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Own clinic has updated the status of an employee',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $employee->user_id,
            'notifDescription' => 'Your status have been updated to '. $employee->accountStatus. 
            ' for ' . $var->clinicName,
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $var->id,
            'notifDescription' => 'Own clinic has updated the status of an employee',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', $message);
    }

    public function display_records() {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->get()->first();
        $clinic = Clinic::where('id', $employee->clinic_id)->get()->first();
        $patient = Patient::where('clinic_id', $employee->clinic_id)->get();
        return view('/clinic/record/index', ['clinic'=>$clinic, 'patient'=>$patient]);
    }

    public function getRecord(Request $request, Patient $patient) {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->get()->first();

        if ($request->ajax()){
            $data = Patient::where('clinic_id', $employee->clinic_id)->with('userPatient');
            return Datatables::eloquent($data)
                             ->addIndexColumn()
                             ->addColumn('actions', 'clinic.record.action')
                             ->rawColumns(['actions'])
                             ->addColumn('userPatient', function(Patient $patient) {
                                return $patient->userPatient->lastName . " , " . $patient->userPatient->firstName
                                . " " . $patient->userPatient->middleName;
                             })
                             ->editColumn('created_at', function($row) {
                                return Carbon::parse($row->created_at)->format('F j , Y');
                             })
                             ->editColumn('updated_at', function($row) {
                                return Carbon::parse($row->updated_at)->format('F j , Y');
                             })
                             ->setRowId(function ($patient) { return $patient->id; })
                             ->toJson();
        }

    }

    public function view_records($id) {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->get()->first();
        $clinic = Clinic::where('id', $employee->clinic_id)->get()->first();
        $patient = Patient::find($id);

        $temp = Carbon::parse($patient->created_at)->format('F j , Y');

        return view('/clinic/record/view', ['clinic'=>$clinic, 'patient'=>$patient, 'temp'=>$temp]);
    }

    public function history_records(Patient $patient) {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->get()->first();
        $clinic = Clinic::where('id', $employee->clinic_id)->get()->first();
        $var = Patient::find($patient); 
        $temp = Booking::where('patient_id', $patient->id)->where('clinic_id', $employee->clinic_id)->get();
        return view('/clinic/record/history', ['clinic'=>$clinic, 'temp'=>$temp, 'patient'=>$patient]);
    }    

    public function calendar(Request $request) { 
        $user = auth()->user();
        $var = Employee::where('user_id', $user->id)->get('clinic_id')->first(); 
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();

        if($request->ajax()) {
       
            $data = Booking::where('clinic_id', $var->clinic_id)
                    ->where('status', 'In Progress' )
                    ->whereDate('start', '>=', $request->start)
                    ->whereDate('end',   '<=', $request->end)
                    ->get(['id','user_id', 'start', 'end']);
               
            for ($i=0; $i < count($data); $i++) { 
                $vars[$i]= User::where('id', $data[$i]->user_id)->get('lastName')->first(); 
                $data[$i]['title'] = $vars[$i]->lastName;
            }

            return response()->json($data);
        }


        return view('/clinic/calendar/index', ['clinic'=>$clinic]);
    }

    public function notification() {
        $user = auth()->user();
        $var = Employee::where('user_id', $user->id)->get('clinic_id')->first(); 
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();

        return view ('/clinic/notification/index', ['clinic'=>$clinic]);  
    }

    public function getNotification(Request $request) {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->get()->first();

        if ($request->ajax()){
            $data = ClinicNotification::where('clinic_id', $employee->clinic_id);
            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('actions', 'clinic.notification.action')
                            ->rawColumns(['actions'])
                            ->editColumn('notifDateTime', function($row){
                            return Carbon::parse($row->notifDateTime)->format('F j , Y  h:i A');
                            })
                            ->setRowId(function ($patient) { return $patient->id; })
                            ->make(true);
        }              
    }

    public function delete_notification($id) {
        $var = ClinicNotification::find($id);
        $user = auth()->user(); 
        
        $var->delete();

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has deleted a notification for ' . $var->clinicName,
            'dateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Notification has been deleted!');
    }

    //CALENDAR FOR CLINIC EMPLOYEE
    public function calendar_employee(Request $request){ 
        $user = auth()->user(); 
        $var = Employee::where('user_id', $user->id)->get('id')->first(); 
        if($request->ajax()) {
       
            $data = Booking::where('employee_id', $var->id)
                    ->where('status', 'In Progress')
                    ->whereDate('start', '>=', $request->start)
                    ->whereDate('end',   '<=', $request->end)
                    ->get(['id','user_id', 'start', 'end']);
               
            for ($i=0; $i < count($data); $i++) { 
                $vars[$i]= User::where('id', $data[$i]->user_id)->get('lastName')->first(); 
                $data[$i]['title'] = $vars[$i]->lastName;
            }

            return response()->json($data);
        }


        return view('/calendar/index', ['user'=>$user]);
    }

    //CLINIC DASHBOARD
    public function dashboard_clinic(){
       
        $user = auth()->user(); 
        $var = Employee::where('user_id', $user->id)->get()->first();
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first(); 

        $service = Service::where('clinic_id', $var->clinic_id)->get();
        $star = Rating::where('clinic_id', $var->id)->avg('starRating');
        $average = round($star, 2);

        $booking_status = Booking::where('clinic_id', $var->clinic_id)->select(\DB::raw("COUNT(*) as count3"), 
        \DB::raw("status"))
        ->groupBy('status')
        ->orderBy('count3')
        ->get();

        $employeeCount = Employee::where('clinic_id', $var->clinic_id)->select(\DB::raw("COUNT(*) as count4"), 
        \DB::raw("accountStatus as accountStatus"))
        ->groupBy('accountStatus')
        ->orderBy('count4')
        ->get();

        return view('/clinic/dashboard/index', ['clinic'=>$clinic, 'service'=>$service,
        'average'=>$average, 'employeeCount'=>$employeeCount,'booking_status'=>$booking_status]);
    }

}
