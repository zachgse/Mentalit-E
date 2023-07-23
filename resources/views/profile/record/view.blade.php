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
                        <a href="/profile/record/index">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>

                    <div class="p-2 bd-highlight">
                        <h4>Patient Medical Record for {{$record->clinicPatient->clinicName}}</h4>
                    </div>

                    <div class="p-2 bd-highlight"></div>
                </div>

                <br><hr class="divider"><br><br>

                <div class="d-flex bd-highlight mb-3">
                    <div class="me-auto p-2 bd-highlight">
                        <b>Name: </b>{{$record->userPatient->firstName}} {{$record->userPatient->MiddleName}} {{$record->userPatient->lastName}}               
                    </div>
                    <div class="p-2 bd-highlight"></div>
                    <div class="p-2 bd-highlight">
                        <b>Date first consulted: </b>{{$temp}}
                    </div>
                </div>

                <a href="/profile/record/{{$record->id}}/history" class="pull-left">
                    <button class="btn btn-outline">Booking history in the clinic</button>
                </a>

                <br><br><hr><br>
                   
                <div class="row">
                    <h4 class="text-center">Emergency contact number</h4>
                    <i class="text-center mb-5">(To be filled by the health professional during booking)</i>

                    <div class="col-lg-6">

                        <div class="mb-3 auto">
                            <label for="exampleInputEmail1" class="form-label bold pull-left">Name of person</label>
                            <br><br>
                            <p class="pull-left ms-3">{{$record->emergencyName}}</p>
                        </div>

                        <br>

                        <div class="mb-3 auto">
                            <label for="exampleInputEmail1" class="form-label bold pull-left">Contact Number</label>
                            <br><br>
                            <p class="pull-left ms-3">{{$record->emergencyNumber}}</p>
                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="mb-3 auto">
                            <label for="exampleInputEmail1" class="form-label bold pull-left">Address</label>
                            <br><br>
                            <p class="pull-left ms-3">{{$record->emergencyAddress}}</p>
                        </div>   

                    </div>

                </div>
        
                    <br><hr><br>

                    <h4 class="text-center mb-5">Medical History</h4>
                        
                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Family History</label>
                        <br><br>
                        <p class="pull-left ms-3">{{$record->familyHistory}}</p>
                    </div>

                    <br>

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Social History</label>
                        <br><br>
                        <p class="pull-left ms-3">{{$record->socialHistory}}</p>                        
                    </div>

                    <br>

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Medical History</label>
                        <br><br>
                        <p class="pull-left ms-3">{{$record->medicalHistory}}</p>    
                    </div>
                
                    <br><hr><br>     

                    <h4 class="text-center mb-5">Current State</h4>

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Mental State</label>
                        <br><br>
                        <p class="pull-left ms-3">{{$record->currentMentalState}}</p>    
                    </div>

                    <br>

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Medical Treatment</label>
                        <br><br>
                        <p class="pull-left ms-3">{{$record->currentMedicalTreatment}}</p>    
                    </div>

            </div> <!--here-->

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection

	






