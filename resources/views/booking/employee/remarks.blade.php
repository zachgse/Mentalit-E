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

                @if($booking->status == "In Progress")
                <h4 class="text-center my-5">Booking Remarks</h4>
                  
                <form action="/booking/employee/{{$booking->id}}/store" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Reason of booking: </label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" name="reason" rows="2" required autocomplete="reason">{{ old('reason') }}</textarea>
                        @error('reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                    </div>

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Refer to : </label>
                        <textarea class="form-control @error('referTo') is-invalid @enderror" name="referTo" rows="2" required autocomplete="referTo">{{ old('referTo') }}</textarea>
                        @error('referTo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror   
                    </div>  
                    
                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Diagnosis : </label>
                        <textarea class="form-control @error('diagnosis') is-invalid @enderror" name="diagnosis" rows="2" required autocomplete="diagnosis">{{ old('diagnosis') }}</textarea>
                        @error('diagnosis')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror   
                    </div>      
                    
                    
                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Prescription/Receipt : </label>
                        <input class="form-control auto @error('fileUpload') is-invalid @enderror" type="file" name="fileUpload" accept="image/*, application/pdf, application/msword, .doc, .docx" required autocomplete="fileUpload">
                        @error('fileUpload')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror   
                    </div>

                    <br>

                    <div class="w-50 auto">
                        <input type="checkbox" name="permission" value="1" required> 
                        I am aware and responsible for the outcome and risks of handling the information regarding my patients.
                    </div>
                    
                    <br><hr><br>
                    <div class="d-flex bd-highlight">

                        <div class="me-auto p-2 bd-highlight"></div>					
                        <div class="p-2 bd-highlight">
                            <button type="submit" class="btn btn-outline" onclick="return confirm('Update the booking?')">Submit</button>
                        </div>

                </form>
                @endif


    
            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection

				






