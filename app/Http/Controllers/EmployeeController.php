<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Clinic;
use App\Models\ClinicNotification;
use App\Models\Notification;
use App\Models\Log;
use App\Models\Employee;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clinics = Clinic::all();
        return view('apply.index', ['clinics'=>$clinics]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
        $clinic = $request->clinic_id;
        $var = Clinic::find($clinic);

        if($request->hasfile('prcLicense')) {
            $file = $request->file('prcLicense');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('storage/prcLicense/', $filename);
        }        

        $user = auth()->user();

        $clinic = Employee::create([
            'user_id' => $user->id,
            'clinic_id' => $clinic,
            'prcLicense' => $filename,
            'accountStatus' => 'Pending',
        ]);


        Log::create([
            'user_id' => $user->id,
            'type' => 'Clinic', 
            'description' => $user->email . ' has applied for ' . $var->clinicName,
            'dateTime' => now(),
        ]);

        Notification::create([
            'user_id' => $user->id,
            'notifDescription' => 'You applied for the clinic '. $var->clinicName,
            'notifDateTime' => now(),
        ]);

        ClinicNotification::create([
            'clinic_id' => $var->id,
            'notifDescription' => $user->email . ' has applied for the clinic ',
            'notifDateTime' => now(),
        ]);

        return redirect()->back()->with('message',' Your application is ongoing. Please contact your Clinic Administrator');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
