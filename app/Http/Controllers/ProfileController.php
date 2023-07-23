<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Log;
use App\Models\Booking;
use App\Models\Clinic;
use App\Models\Patient;
use App\Models\Journal;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\GiveAward;
use DataTables;
use Carbon\Carbon;

//Validation Rules
use App\Rules\AlphaSpace;
use App\Rules\PHNumber;
use App\Rules\Uppercase;
use App\Rules\MiddleInitial;
use App\Rules\ZipCode;
use App\Rules\StreetNo;

use App\Rules\IsOldPassword;
use App\Rules\MatchOldPassword;




class ProfileController extends Controller
{

    public function index(User $user) {
        $user = auth()->user();
        $award = GiveAward::where('user_id', $user->id)->get();
        return view ('/profile/profile/index',  ['user' => $user, 'award'=>$award]);
    }

    //METHODS FOR EDIT INFO

    public function edit(User $user) {
        $user = auth()->user();
        return view ('/profile/profile/edit', ['user' => $user]);
    }

    public function change_password(User $user) {
        $user = auth()->user();
        return view ('/profile/profile/change', ['user' => $user]);
    }

    public function update_password(Request $request){
        $users = auth()->user();
        $user = User::find($users->id);

        request()->validate([
            'old-password' => ['required', new MatchOldPassword],
            'password' => ['required', 'string', 'min:8', 'confirmed', new IsOldPassword],                                     
        ]);

        $user->update([
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' has changed password ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You changed your password',
            'notifDateTime' => now(),
        ]);
        
        return redirect('/profile/profile/edit')->with('message', 'Password has been changed!');
    }


    public function update_image(Request $request) {
        $users = auth()->user();
        $user = User::find($users->id);

        request()->validate([
            'profile_image' => 'mimes:jpg,jpeg,png|max:4096',                                                             
        ]);

        if($request->hasfile('profile_image'))
        {
            $destination = 'storage/avatars/'.$user->profile_image;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $file = $request->file('profile_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('storage/avatars/', $filename);
            $user->profile_image = $filename;
        }

        $user->update();

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' has updated information ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You updated your information',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Profile picture has been updated successfully!');

    }

    public function update_info(Request $request) {
        $users = auth()->user();
        $user = User::find($users->id);

        request()->validate([
            'firstName' => ['required', 'min:2', 'max:50', new AlphaSpace],
            'middleName' => ['nullable', 'min:2', 'max:50', new AlphaSpace],
            'lastName' => ['required', 'min:2', 'max:50', new AlphaSpace],
            'contactNo' => ['required', 'max:13', new PHNumber],
            'city' => ['required', 'max:50', new AlphaSpace],
            'barangay' => ['required','max:50'],        
            'streetNumber' => ['required', 'max:50'],          
            'zipCode' => ['required', new ZipCode],                                                                 
        ]);

        $user->update([
            'firstName' => request('firstName'),
            'middleName' => request('middleName'),
            'lastName' => request('lastName'),
            'contactNo' => request('contactNo'),
            'city' => request('city'),
            'barangay' => request('barangay'),      
            'streetNumber' => request('streetNumber'),    
            'zipCode' => request('zipCode'),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' has updated information ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You updated your information',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'User information updated successfully!');
    }

    //METHODS FOR CALENDAR
    public function calendar(Request $request) { 
        $user = auth()->user();

        if($request->ajax()) {
       
            $data = Booking::where('user_id', $user->id)
                    ->where('status', 'In Progress' )
                    ->whereDate('start', '>=', $request->start)
                    ->whereDate('end',   '<=', $request->end)
                    ->get(['id','user_id', 'start', 'end', 'clinic_id']);
               
            for ($i=0; $i < count($data); $i++) { 
                $var[$i]= Clinic::where('id', $data[$i]->clinic_id)->get('clinicName')->first(); 
                $data[$i]['title'] = $var[$i]->clinicName;
            }

            return response()->json($data);
        }


        return view('/profile/calendar/index', ['user'=>$user]);
    }

    //METHODS FOR MEDICAL RECORD
    public function record() {
        $user = auth()->user();
        return view ('/profile/record/index', ['user'=>$user]);
    }

    public function getRecord(Request $request) {
        $user = auth()->user();

        if($request->ajax()) {
            $data = Patient::where('user_id', $user->id)->with('clinicPatient');
            return Datatables::eloquent($data)
                    ->addIndexColumn()
                    ->editColumn('actions', 'profile.record.action')
                    ->rawColumns(['actions'])
                    ->addColumn('clinicName', function($row) {
                        return $row->clinicPatient->clinicName;
                    })
                    ->editColumn('created_at', function($row){
                        return Carbon::parse($row->created_at)->format('F j , Y  h:i A');
                    }) 
                    ->editColumn('updated_at', function($row){
                        return Carbon::parse($row->updated_at)->format('F j , Y  h:i A');
                    }) 
                    ->setRowId(function ($record) { return $record->id; })
                    ->toJson();
        }
    }

    public function view_record($id) {
        $user = auth()->user();
        $record = Patient::find($id);
        $temp = Carbon::parse($record->created_at)->format('F j , Y');
        return view ('/profile/record/view', ['user'=>$user, 'record'=>$record, 'temp'=>$temp]);
    }

    public function view_history($record) {
        $user = auth()->user();
        $single = Patient::where('id', $record)->get()->first();
        $booking = Booking::where('patient_id', $record)->get();
        $var = Booking::where('patient_id', $record)->get('clinic_id')->first();
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();
        return view ('/profile/record/history', ['user'=>$user, 'booking'=>$booking, 'clinic'=>$clinic, 'single'=>$single]);
    }

    //METHODS FOR JOUNAL
    public function journal() {
        $user = auth()->user();
        return view ('/profile/journal/index', ['user'=>$user]);
    }

    public function getJournal(Request $request) {
        $user = auth()->user();
        if ($request->ajax()) {
            $data = Journal::where('user_id', $user->id);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('actions', 'profile.journal.action')
                    ->rawColumns(['actions'])
                    ->make(true);
        }
    }

    public function create_journal() {
        $user = auth()->user();
        return view ('/profile/journal/create', ['user'=>$user]);
    }

    public function store_journal(Request $request) {
        $user = auth()->user();

        request()->validate([
            'journalSubject' => ['required', 'string', 'min:5', 'max:30'],
            'journalDescription' => ['required', 'string', 'min:10', 'max:255']
        ]);

        Journal::create([
            'user_id' => $user->id,
            'journalSubject' => request('journalSubject'),
            'journalDescription' => request('journalDescription'),
            'journalDateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' has created a journal ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You created a journal',
            'notifDateTime' => now(),
        ]);

        return redirect('/profile/journal/index')->with('message', 'Journal entry has been created');
    }

    public function view_journal($id) {
        $user = auth()->user();
        $journal = Journal::find($id);
        return view ('/profile/journal/view', ['user'=>$user, 'journal'=>$journal]);
    }

    public function edit_journal($id) {
        $user = auth()->user();
        $journal = Journal::find($id);
        return view ('/profile/journal/edit', ['user'=>$user, 'journal'=>$journal]);
    }

    public function update_journal(Request $request, $id) {
        $journal = Journal::find($id);
        $user = auth()->user();

        request()->validate([
            'journalSubject' => ['required', 'string', 'min:5', 'max:30'],
            'journalDescription' => ['required', 'string', 'min:10', 'max:255']
        ]);

        $journal->update([
            'journalSubject' => request('journalSubject'),
            'journalDescription' => request('journalDescription'),
            'journalDateTime' => now(),
        ]);

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' has updated a journal ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You updated a journal',
            'notifDateTime' => now(),
        ]);

        return redirect('/profile/journal/index')->with('message', 'Journal entry has been updated');
    }

    public function delete_journal(Request $request, $id) {
        $journal = Journal::find($id);
        $user = auth()->user();

        $journal->delete();

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' has deleted a journal ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You deleted a journal',
            'notifDateTime' => now(),
        ]);

        return redirect('/profile/journal/index')->with('message', 'Journal entry has been deleted');
    }

    //METHODS FOR NOTIF
    public function notification() {
        $user = auth()->user();
        return view('/profile/notification/index', ['user'=>$user]);
    }

    public function getNotification(Request $request) {
        $user = auth()->user();
        
        if ($request->ajax()) {
            $data = Notification::where('user_id', $user->id);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('notifDateTime', function($row){
                        return Carbon::parse($row->notifDateTime)->format('F j , Y  h:i A');
                    })
                    ->make(true);
        }
    }

    //METHODS FOR TICKET

    public function ticket() {
        $user = auth()->user();
        return view('/profile/ticket/index', ['user'=>$user]);
    }

    public function getTicket(Request $request) {
        $user = auth()->user();

        if($request->ajax()) {
            $data = Ticket::where('user_id', $user->id)->orderBy('dateTimeIssued', 'desc');
            return DataTables::of($data)
                ->AddIndexColumn()
                ->addColumn('actions', 'profile.ticket.action')
                ->editColumn('dateTimeIssued', function($row){
                    return Carbon::parse($row->dateTimeIssued)->format('F j , Y  h:i A');
                })
                ->editColumn('dateTimeResolved', function($row){
                    return Carbon::parse($row->dateTimeResolved)->format('F j , Y  h:i A');
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function create_ticket() {
        $user = auth()->user();
        return view('/profile/ticket/create', ['user'=>$user]);
    }

    public function store_ticket(Request $request) {
        $user = auth()->user();

        request()->validate([
            'ticketSubject' => ['required', 'string', 'min:5', 'max:30'],
            'ticketDescription' => ['required', 'string', 'min:10', 'max:255'],
            'ticketCategory' => 'required',
            'file' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() .'.'.$extension;
            $file->move('storage/ticket/', $filename);
            Ticket::create([
                'user_id' => $user->id,
                'ticketSubject' => request('ticketSubject'),
                'ticketCategory' => request('ticketCategory'),
                'ticketDescription' => request('ticketDescription'),
                'file' => $filename,
                'dateTimeIssued' => now(),
            ]);
        } else {
            Ticket::create([
                'user_id' => $user->id,
                'ticketSubject' => request('ticketSubject'),
                'ticketCategory' => request('ticketCategory'),
                'ticketDescription' => request('ticketDescription'),
                'dateTimeIssued' => now(),
            ]);            
        }

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' filed a new ticket ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You filed a new ticket',
            'notifDateTime' => now(),
        ]);

        return redirect('/profile/ticket/index')->with('message', 'Ticket has been filed');
    }

    public function view_ticket($id) {
        $user = auth()->user();
        $var = Ticket::find($id);
        $comments = TicketComment::where('ticket_id', $id)->orderBy('ticketCommentDateTime', 'desc')->get();
        return view('/profile/ticket/view', ['user'=>$user, 'var'=>$var, 'comments'=>$comments]);
    }

    public function store_comment(Request $request, $var) {
        $user = auth()->user();
        $ticket = Ticket::find($var);

        request()->validate([
            'ticketCommentContent' => ['required','string', 'min:5', 'max:255'],
            'file' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096',
        ]);

        $ticketComment = TicketComment::create([
            'user_id' => $user->id,
            'ticket_id' => $ticket->id,
            'ticketCommentContent' => request('ticketCommentContent'),
            'ticketCommentDateTime' => now(), 
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() .'.'.$extension;
            $file->move('storage/ticket/', $filename);
            $ticketComment->file = $filename;
        }
        
        $ticketComment->save();

        $ticket->update([
            'dateTimeUpdated' => now(),
            'ticketStatus' => 'Pending',
        ]);      
        
        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' responded to a ticket ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You responded to a ticket ',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Ticket feedback has been submitted!');
    }

}
