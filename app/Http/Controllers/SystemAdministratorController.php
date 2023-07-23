<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\User;
use App\Models\ClinicNotification;
use App\Models\Notification;
use App\Models\Award;
use App\Models\GiveAward;
use App\Models\Payment;
use App\Models\Clinic;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\Forum;
use App\Models\ForumComment;
use App\Models\Warning;
use App\Models\Booking;
use App\Models\Employee;
use DataTables;
use Carbon\Carbon;

use PDF;

class SystemAdministratorController extends Controller
{

    public function javascriptError()
    {
        return view('/errors/js');
    }

    //MANAGE AUDIT LOGS
    public function log() {
        $user = auth()->user();
        $logs = Log::all();
        return view('/systemadmin/log/index', ['user'=>$user, 'logs'=>$logs]);
    }

    public function getLog() {
        $data = Log::with('userLog');
        return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('userEmail', function($row) {
                    return $row->userLog->email;
                })
                ->toJson();
    }

    //MANAGE USERS
    public function user() {
        $user = auth()->user();
        $data = User::all();
        return view ('/systemadmin/user/index', ['user'=>$user]);
    }

    public function getUser(Request $request) {
        if($request->ajax()) {
            $data = User::all();
            return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('actions', 'systemadmin.user.action')
                        ->addColumn('status', 'systemadmin.user.status')
                        ->rawColumns(['actions', 'status'])
                        ->setRowId(function ($users) { return $users->id; })
                        ->make(true);
        }
    }

    public function activate_user(Request $request, $id) {
        $user = User::find($id);

        $auth = auth()->user();
        if ($auth->id == $user->id){
            abort(403);
        } 

        if ($user->status == 1) {
            $user->update([
                'status' => 0,
            ]);
            $message = "Account has been deactivated";
        } else {
            $user->update([
                'status' => 1,
            ]);
            $message = "Account has been activated";
        }

        Log::create([
            'user_id' => $user->id,
            'type' => 'User', 
            'description' => $user->email . ' has been activated ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Your account has been activated ',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', $message);
    }

    public function send_notification($users) {
        $var = User::find($users);
        $user = auth()->user();
        if ($user->id == $var->id){
            abort(403);
        } 
        return view ('/systemadmin/user/notify', ['user'=>$user, 'var'=>$var]);
    }

    public function store_notification(Request $request, $users) {
        $var = User::find($users);
      
        request()->validate([
            'notifDescription' => ['required','string', 'min:5', 'max:250'],
        ]);

        Log::create([
            'user_id' => $var->id,
            'type' => 'User', 
            'description' => $var->email . ' received a notification from System Administrator ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $var->id,
            'notifDescription' => request('notifDescription'),
            'notifDateTime' => now(),
        ]);

        return redirect('/systemadmin/user/index')->with('message', 'Notification has been sent to the user');
    }

    public function send_warning($users) {
        $var = User::find($users);
        $user = auth()->user();
        if ($user->id == $var->id){
            abort(403);
        } 
        return view ('/systemadmin/user/warning', ['user'=>$user, 'var'=>$var]);
    }

    public function store_warning(Request $request, $users) {
        $var = User::find($users);
        $temp = User::where('id', $users)->get()->first();

        request()->validate([
            'notifDescription' => ['required','string', 'min:5', 'max:250'],
        ]);

        Log::create([
            'user_id' => $var->id,
            'type' => 'User', 
            'description' => $var->email . ' received a warning from System Administrator ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $var->id,
            'notifDescription' => request('notifDescription'),
            'notifDateTime' => now(),
        ]);

        $warning = 1;
        $currentWarning = $var->warningCount;


        $temp->warningCount = $currentWarning + $warning;   

        if($temp->warningCount == 3) {
            $temp->status = 0;
        }

        $temp->save();


        return redirect('/systemadmin/user/index')->with('message', 'Warning has been sent to the user');
    }

    public function send_award_user($users) {
        $var = User::find($users);

        $auth = auth()->user();
        if ($auth->id == $var->id){
            abort(403);
        } 

        $awards = Award::all();
        $user = auth()->user();
        return view ('/systemadmin/user/award', ['user'=>$user, 'var'=>$var, 'awards'=>$awards]);
    }

    public function store_award_user(Request $request, $users) {
        $var = User::find($users);
        $user = auth()->user();

        request()->validate([
            'notifDescription' => 'required',
            'award_id' => 'required',
        ]);

        GiveAward::create([
            'user_id' => $var->id,
            'award_id' => request('award_id'),
        ]);

        Log::create([
            'user_id' => $var->id,
            'type' => 'User', 
            'description' =>  request('notifDescription'),
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $var->id,
            'notifDescription' => request('notifDescription'),
            'notifDateTime' => now(),
        ]);

        return redirect('/systemadmin/user/index')->with('message', 'Award has been sent to the user');
    }

    //MANAGE PAYMENT METHOD
    public function payment() {
        $user = auth()->user();
        return view('/systemadmin/payment/index', ['user'=>$user]);
    }

    public function getPayment(Request $request) {
        if($request->ajax()) {
            $data = Payment::with(['clinicPayment', 'userPayment']);
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('actions', 'systemadmin.payment.action')
                ->editColumn('paymentProof', 'systemadmin.payment.proof')
                ->editColumn('subscription_id', 'systemadmin.payment.subscription')
                ->addColumn('clinicName', function($row){
                    return $row->clinicPayment->clinicName;
                })
                ->addColumn('clinicAddress', function($row){
                    return $row->userPayment->email;
                })
                ->rawColumns(['actions', 'paymentProof', 'subscription_id'])
                ->toJson();
        }
    }

    public function accept_payment(Request $request, $id) {
        $payment = Payment::find($id);
        $var = Payment::where('id', $payment->id)->get('subscription_id')->first();
        $clinic = Clinic::where('id', $payment->clinic_id)->get()->first();
        $employee = Employee::where('user_id', $clinic->user_id)->get()->first();


        $currentDuration = $clinic->subscriptionDuration;
  
        if ($var->subscription_id == 1) {
            $subDuration = 30; 
        } elseif ($var->subscription_id == 2) {
            $subDuration = 90;
        } elseif ($var->subscription_id == 3) {
            $subDuration = 180;
        }

        $clinic->update([
            'subscriptionDuration' => $currentDuration + $subDuration,
            'clinicStatus' => 1,
        ]);

        $payment->update([
            'paymentStatus' => 'Accepted',
        ]);

        $employee->update([
            'accountStatus' => 'Active',
        ]);

        Log::create([
            'user_id' => $employee->user_id,
            'type' => 'User', 
            'description' => $clinic->clinicName . ' payment approved for subscription ',
            'dateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->id,
            'notifDescription' => $clinic->clinicName . ' payment approved for subscription ',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $employee->user_id,
            'notifDescription' => $clinic->clinicName . ' payment approved for subscription ',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Payment regarding the subscription has been accepted and the clinic will be notified');
    }

    public function decline_payment(Request $request, $id) {
        $payment = Payment::find($id);
        $clinic = Clinic::where('id', $payment->clinic_id)->get()->first();
        $employee = Employee::where('user_id', $clinic->user_id)->get()->first();

        $payment->update([
            'paymentStatus' => 'Declined',
        ]);

        Log::create([
            'user_id' => $employee->user_id,
            'type' => 'User', 
            'description' => $clinic->clinicName . ' payment declined for subscription ',
            'dateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->id,
            'notifDescription' => $clinic->clinicName . ' payment declined for subscription ',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $employee->user_id,
            'notifDescription' => $clinic->clinicName . ' payment declined for subscription ',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Payment regarding the subscription has been declined and the clinic will be notified');
    }

    public function delete_payment(Request $request, $id) {
        $payment = Payment::find($id);
        $clinic = Clinic::where('id', $payment->clinic_id)->get()->first();
        $employee = Employee::where('user_id', $clinic->user_id)->get()->first();

        $payment->delete();

        Log::create([
            'user_id' => $employee->user_id,
            'type' => 'User', 
            'description' => $clinic->clinicName . ' payment has been deleted ',
            'dateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Payment has been deleted');
    }

    //MANAGE CLINIC METHODS
    public function clinic() {
        $user = auth()->user();
        return view ('/systemadmin/clinic/index', ['user'=>$user]);
    }

    public function getClinic(Request $request) {        
        if ($request->ajax()){
            $data = Clinic::with('userClinic');
            return Datatables::eloquent($data)
                    ->addIndexColumn()
                    ->addColumn('actions', 'systemadmin.clinic.action')
                    ->editColumn('status', 'systemadmin.clinic.status')
                    ->rawColumns(['actions', 'status'])
                    ->addColumn('clinicEmail', function($row){
                        return $row->userClinic->email; 
                    })      
                    ->addColumn('clinicAdminName', function($row){
                        return $row->userClinic->lastName; 
                    })                                        
                    ->toJson();
        }
    }

    public function activate_clinic(Request $request, $id) {
        $clinic = Clinic::find($id);

 
        if($clinic->clinicStatus == 1) {
            $clinic->update([
                'clinicStatus' => 0,
            ]);
            $message = "Clinic has been deactivated and the clinic will be notified";
        } else {
            $clinic->update([
                'clinicStatus' => 1,
            ]);
            $message = "Clinic has been activated and the clinic will be notified";
        }

        Log::create([
            'user_id' => $clinic->user_id,
            'type' => 'User', 
            'description' => $clinic->clinicName . ' status has been updated ',
            'dateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $clinic->id,
            'notifDescription' => $clinic->clinicName . ' status has been updated ',
            'notifDateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $clinic->user_id,
            'notifDescription' => $clinic->clinicName . ' status has been updated ',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', $message);

    }

    //MANAGE TICKETING METHODS
    public function ticket() {
        $user = auth()->user();
        return view('/systemadmin/ticket/index', ['user'=>$user]);
    }

    public function getTicket(Request $request) {
        $user = auth()->user();

        if($request->ajax()) {
            $data = Ticket::orderBy('dateTimeIssued', 'desc')->with('userTicket');
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('actions', 'systemadmin.ticket.action')
                ->addColumn('userEmail', function($row){
                    return $row->userTicket->email; 
                })
                ->editColumn('dateTimeIssued', function($row){
                    return Carbon::parse($row->dateTimeIssued)->format('F j , Y  h:i A');
                })
                ->editColumn('dateTimeUpdated', function($row){
                    return Carbon::parse($row->dateTimeUpdated)->format('F j , Y  h:i A');
                })
                ->editColumn('dateTimeResolved', function($row){
                    return Carbon::parse($row->dateTimeResolved)->format('F j , Y  h:i A');
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
    }

    public function create_ticket() {
        $user = auth()->user();
        return view('/systemadmin/ticket/create', ['user'=>$user]);
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
            $ticket = Ticket::create([
                'user_id' => $user->id,
                'ticketSubject' => request('ticketSubject'),
                'ticketCategory' => request('ticketCategory'),
                'ticketDescription' => request('ticketDescription'),
                'file' => $filename,
                'dateTimeIssued' => now(),
            ]);
        } else {
            $ticket = Ticket::create([
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

        return redirect('/systemadmin/ticket/index')->with('message', 'Ticket has been filed');
    }    

    public function view_ticket($id) {
        $user = auth()->user();
        $var = Ticket::find($id);
        $comments = TicketComment::where('ticket_id', $id)->orderBy('ticketCommentDateTime', 'desc')->get();

        if($var->ticketStatus == "Closed" || $var->ticketStatus == "Archived") {
            return view('/systemadmin/ticket/view', ['user'=>$user, 'var'=>$var, 'comments'=>$comments]);
        } else {
            $var->update([
                'ticketStatus' => "Pending",
            ]);
            return view('/systemadmin/ticket/view', ['user'=>$user, 'var'=>$var, 'comments'=>$comments]);
        }
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
            'user_id' => $ticket->user_id,
            'type' => 'User', 
            'description' => $ticket->email . ' received a response for the ticket',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $ticket->user_id,
            'notifDescription' => 'You receive a response on your ticket',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Ticket feedback has been submitted!');
    }    

    public function close_ticket(Request $request, $id) {
        $ticket = Ticket::find($id);
        
        $ticket->update([
            'ticketStatus' => 'Closed',
            'dateTimeUpdated' => now(),
            'dateTimeResolved' => now(),
        ]);

        Log::create([
            'user_id' => $ticket->user_id,
            'type' => 'User', 
            'description' => $ticket->email . ' ticket has been closed ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $ticket->user_id,
            'notifDescription' => 'Your ticket has been closed',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'The ticket has been closed and the User will be notified');
    }

    public function archive_ticket(Request $request, $id) {
        $ticket = Ticket::find($id);
        
        $ticket->update([
            'ticketStatus' => 'Archived',
        ]);

        Log::create([
            'user_id' => $ticket->user_id,
            'type' => 'User', 
            'description' => $ticket->email . ' ticket has been archived ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $ticket->user_id,
            'notifDescription' => 'Your ticket has been archived',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'The ticket has been archived');
    }

    //MANAGE COMMUNITY FORUM

    public function forum() {
        $user = auth()->user();
        return view ('/systemadmin/forum/index', ['user'=>$user]);
    }

    public function getForum(Request $request) {
        if($request->ajax()) {
            $data = Forum::orderBy('dateTime', 'desc')->with('userForum');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', '/systemadmin/forum/action')
                    ->rawColumns(['actions'])
                    ->addColumn('userName', function ($row) {
                        return $row->userForum->email;
                    })
                    ->setRowId(function ($forum) { return $forum->id;})
                    ->toJson(); 
        }
    }

    public function delete_forum($id) {
        $forum = Forum::find($id);
        $forum->delete();

        $var = User::where('id', $forum->user_id)->get()->first();

        Log::create([
            'user_id' => $var->id,
            'type' => 'User', 
            'description' => $var->email . ' post has been deleted ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $var->id,
            'notifDescription' => 'Your post has been deleted',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message', 'Community Post has been deleted and the user will be notified');     
    }

    public function forumComment($id) {
        $forum = Forum::where('id', $id)->get()->first();
        $user = auth()->user();
        return view ('/systemadmin/forum/comment/index', ['user'=>$user,'forum'=>$forum]);
    }

    public function getForumComment(Request $request, Forum $forum) {
        $var = Forum::where('id', $forum->id)->get()->first();
        if($request->ajax()) {
            $data = ForumComment::where('forum_id', $var->id)->with('userForumComment');

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('actions', '/systemadmin/forum/comment/action')
                    ->rawColumns(['actions'])
                    ->addColumn('userName', function ($row) {
                        return $row->userForumComment->email;
                    })
                    ->toJson(); 
        }
    }

    public function delete_comment($id) {
        $forumComment = ForumComment::find($id);
        $forumComment->delete();

        $var = User::where('id', $forumComment->user_id)->get()->first();

        Log::create([
            'user_id' => $var->id,
            'type' => 'User', 
            'description' => $var->email . ' comment has been deleted ',
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $var->id,
            'notifDescription' => 'Your comment has been deleted',
            'notifDateTime' => now(),
        ]);
        return redirect()->back()->with('message', 'Community Forum comment has been deleted and the user will be notified');
    }

    //MANAGE WARNING TABLE
    public function warning() {
        $user = auth()->user();
        return view('/systemadmin/warning/index', ['user'=>$user]);
    }

    public function getWarning(Request $request) {
        if ($request->ajax()) {
            $data = Warning::orderBy('dateTime', 'desc')->with(['userWarning', 'forumWarning', 'forumCommentWarning']);
            return Datatables::eloquent($data)
                    ->addIndexColumn()
                    ->addColumn('userName', function($row){
                        if ($row->forum_id == null) {
                            return $row->forumCommentWarning->userForumComment->email;
                        } else {
                            return $row->forumWarning->userForum->email;
                        }
                    })
                    ->addColumn('forumPost', function($row){
                        if ($row->forum_id == null) {
                            return $row->forumCommentWarning->forumCommentContent;
                        } else {
                            return $row->forumWarning->forumSubject;
                        }
                    })
                    ->toJson();
        }
    }

     //DASHBOARD
     public function dashboard_admin(){
        $user = auth()->user();
        $users = User::all(); 
        $forum = Forum::all();
        $booking = Booking::all();
        $award = GiveAward::all();
        $clinics = Clinic::all(); 
        $tickets = Ticket::all();

        $ucount = User::select(\DB::raw("COUNT(*) as count"), 
        \DB::raw("MONTHNAME(created_at) as month_name"),\DB::raw('max(created_at) as createdAt'))
        ->whereYear('created_at', date('Y'))
        ->groupBy('month_name')
        ->orderBy('createdAt')
        ->get();

        $cstatuscount = Clinic::select(\DB::raw("COUNT(*) as count4"), \DB::raw("clinicStatus as clinicStatus"))
        ->groupBy('clinicStatus')
        ->orderBy('count4')
        ->get();

        $tstatuscount = Ticket::select(\DB::raw("COUNT(*) as count5"), \DB::raw("ticketStatus as ticketStatus"))
        ->groupBy('ticketStatus')
        ->orderBy('count5')
        ->get();

        return view('/systemadmin/dashboard/index', 
        ['user'=>$user, 'users'=>$users, 'clinics'=>$clinics, 'forum'=>$forum, 'booking'=>$booking, 'award'=>$award,
        'tickets'=>$tickets, 'ucount'=>$ucount, 'cstatuscount'=>$cstatuscount,
        'tstatuscount' => $tstatuscount]); 
                                                     
    }

    //PDF
    public function generatePDF()
    {
        $user = auth()->user();
        $logs = Log::all();

        $pdf = PDF::loadView('/systemadmin/log/pdf', ['user'=>$user,'logs'=>$logs])->setOptions(['defaultFont' => 'sans-serif']);
        //dd($pdf);
        return $pdf->stream();
    }

}
