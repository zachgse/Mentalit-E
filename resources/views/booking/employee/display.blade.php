@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">

        @include('inc.profile')		

        <div class="col-lg-9">

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif         

            <div class="shadow p-5 w-100 standard">
                
                <div class="d-flex justify-content-between">
                    <div class="p-2 bd-highlight">
                        <a href="/booking/employee/index">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>

                    <div class="p-2 bd-highlight">
                        <h4>View Booking</h4>
                    </div>

                    <div class="p-2 bd-highlight"></div>
                </div>

                <br><hr class="divider"><br><br>

                <div class="row">

                    <div class="col-lg-6 text-left">
                        <b>Patient name: </b> {{$booking->userBooking->lastName}}, 
                        {{$booking->userBooking->firstName}} {{$booking->userBooking->middleName}}
                        <br><br>
                        <b>Assigned to: </b> 
                        @if($booking->employee_id == null)
                            None
                        @else 
                            {{$booking->employeeBooking->userEmployee->lastName}},
                            {{$booking->employeeBooking->userEmployee->firstName}}, {{$booking->employeeBooking->userEmployee->middleName}}
                        @endif
                    </div>

                    <div class="col-lg-6 text-right">
                        <b>Date: </b> {{$temp}} to <br> {{$temp2}}
                        <br> 
                        <b>Status: </b> {{$booking->status}}                      
                    </div>
                   
                </div>

                <br><hr><br>

                <h4 class="text-left ms-2">Service availed: {{$booking->serviceBooking->serviceName}}</h4> 
                <br><br>  
                <p class="text-left ms-5">{{$booking->serviceBooking->serviceDescription}}  </p>

                <br><hr>

                @if($booking->status == "To Rate" || $booking->status == "Done")
                    <h4 class="text-center my-5">Booking Remarks</h4>

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Date finished: </label>
                        <br><br>
                        <p class="pull-left ms-5">{{$record->dateTime}}</p>
                    </div>

                    <br><br>                    

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Reason of booking: </label>
                        <br><br>
                        <p class="pull-left ms-5">{{$record->reason}}</p>
                    </div>

                    <br><br>

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Refer to : </label>
                        <br><br>
                        <p class="pull-left ms-5">{{$record->referTo}}</p>
                    </div>  
                    
                    
                    <br><br>
                    
                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Diagnosis : </label>
                        <br><br>
                        <p class="pull-left ms-5">{{$record->diagnosis}}</p>
                    </div>      
                    
                    <br><br>
                    
                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Prescription/Receipt : </label>
                        <br><br>
                        <a href="{{asset('storage/bookingRemarks/' . $record->fileUpload)}}" download>
                            <button class="btn btn-outline pull-left">Download</button>
                        </a>
                    </div>  
                @endif

    
            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection

				






