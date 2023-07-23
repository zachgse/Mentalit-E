<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Clinic;
use App\Models\User;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Log;
use App\Models\Notification;
use App\Models\ClinicNotification;
use Carbon\Carbon;
use DataTables;

//Validations
use App\Rules\AlphaSpace;
use App\Rules\Uppercase;


class ServiceController extends Controller
{


    public function index(Clinic $clinic) {
        $user = auth()->user();
        $var = Employee::where('user_id', $user->id)->get()->first(); 
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();
        $service = Service::where('clinic_id', $var->clinic_id)->get();
        return view ('/clinic/service/index', ['clinic'=>$clinic, 'service'=>$service]);
    }    

    public function getService(Request $request) {
        $user = auth()->user();
        $var = Employee::where('user_id', $user->id)->get()->first(); 
        $service = Service::where('clinic_id', $var->clinic_id)->get();

        if ($request->ajax()) {
            $data = Service::where('clinic_id', $var->clinic_id);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', 'clinic.service.action')
                ->rawColumns(['link','actions'])
                ->editColumn('serviceStart', function($row) {
                    return Carbon::parse($row->serviceStart)->format('F j , Y  h:i A');
                })
                ->editColumn('serviceEnd', function($row) {
                    return Carbon::parse($row->serviceEnd)->format('F j , Y  h:i A');
                })
                ->make(true);
        }
    }

    public function create() {
        $user = auth()->user();
        $var = Employee::where('user_id', $user->id)->get()->first();
        $clinic = Clinic::where('id', $var->clinic_id)->get()->first();
        return view ('/clinic/service/create', ['clinic'=>$clinic]);
    }

    public function store(Request $request, Clinic $clinic) {
        request()->validate([
            'serviceName' => ['required', 'min:2', 'max:50', new AlphaSpace],
            'serviceDescription' => ['required', 'min:10', 'max:255'],
            'servicePrice' => ['required','integer','min:10', 'max:1000000'],
            'serviceStart' => ['required', 'date', 'after:today', 'before:serviceEnd'],
            'serviceEnd' => ['required', 'date', 'after:today', 'after:serviceStart'],
            'serviceLength' => ['required','integer', 'min:1', 'max:1000000'],
        ]);

        $user = auth()->user();

        $var = Employee::where('user_id', $user->id)->get()->first();

        $start =Carbon::parse($request->input('serviceStart'))->format('A');
        $end = Carbon::parse($request->input('serviceEnd'))->format('A');

        if($start == "PM" && $end == "AM") {
            return redirect()->back()->with('message', 'Overnight services are not allowed');
        }

        Service::create([
            'clinic_id' => $var->clinic_id,
            'serviceName' => request('serviceName'),
            'serviceDescription' => request('serviceDescription'),
            'servicePrice' => request('servicePrice'),
            'serviceStart' => request('serviceStart'),
            'serviceEnd' => request('serviceEnd'),
            'serviceLength' => request('serviceLength'),
        ]);


        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has created a service for ' . $var->clinicName,
            'dateTime' => now(),
        ]);

        return redirect('/clinic/service/index')->with('message', 'Service has been created');
    }    

    public function edit($id) {
        $service = Service::where('id', $id)->get()->first();
        $start = Carbon::parse($service->serviceStart)->toDateTimeLocalString();
        $end = Carbon::parse($service->serviceEnd)->toDateTimeLocalString();

        return view ('/clinic/service/edit', ['service'=>$service, 'start'=>$start, 'end'=>$end]);
    }

    public function update(Request $request, Service $service, Clinic $clinic) {
        $vars = Clinic::where('id', $service->clinic_id)->get()->first();
        $var = Service::where('id', $service->id)->get('id')->first();
        $user = auth()->user();

        request()->validate([
            'serviceName' => ['required', 'min:2', 'max:50', new AlphaSpace],
            'serviceDescription' => ['required', 'min:10', 'max:255'],
            'servicePrice' => ['required','integer','min:10', 'max:1000000'],
            'serviceLength' => ['required','integer', 'min:1', 'max:1000000'],
            'serviceStart' => ['required', 'date', 'after:today', 'before:serviceEnd'],
            'serviceEnd' => ['required', 'date', 'after:today', 'after:serviceStart'],
        ]);

        $start =Carbon::parse($request->input('serviceStart'))->format('A');
        $end = Carbon::parse($request->input('serviceEnd'))->format('A');

        if($start == "PM" && $end == "AM") {
            return redirect()->back()->with('message', 'Overnight services are not allowed');
        }

        $var->update([
            'serviceName' => request('serviceName'),
            'serviceDescription' => request('serviceDescription'),
            'servicePrice' => request('servicePrice'),
            'serviceLength' => request('serviceLength'),
            'serviceStart' => request('serviceStart'),
            'serviceEnd' => request('serviceEnd'),
        ]); 

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has updated a service for ' . $vars->clinicName,
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Own clinic has updated a service',
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $vars->id,
            'notifDescription' => 'Own clinic has updated a service',
            'notifDateTime' => now(),
        ]);

        return redirect('/clinic/service/index')->with('message', 'Service has been updated');
    }    

    public function destroy(Request $request, $id) {
        $service = Service::find($id);

        $vars = Clinic::where('id', $service->clinic_id)->get()->first();
        $user = auth()->user();
        
        $service->delete();

        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has deleted a service for ' . $vars->clinicName,
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'Own clinic has deleted a service',
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $vars->id,
            'notifDescription' => 'Own clinic has deleted a service',
            'notifDateTime' => now(),
        ]);

        return redirect('/clinic/service/index')->with('message', 'Service has been deleted');
    }

}
