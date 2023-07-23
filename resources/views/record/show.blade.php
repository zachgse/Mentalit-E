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
                        <h4>Patient Medical Record</h4>
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

                <a href="/record/{{$booking->id}}/history" class="pull-left">
                    <button class="btn btn-outline">Booking history in the clinic</button>
                </a>

                <br><br><hr><br>
                   
                <div class="row">
                    <h4 class="text-center">Emergency contact number</h4>
                    <i class="text-center mb-5">*Contact whenever the patient is at risk*</i>

                    <div class="col-lg-6">

                        <form action="/record/{{$booking->id}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 auto">
                                <label for="exampleInputEmail1" class="form-label bold pull-left">Name of person</label>
                                <input type="text" class="form-control @error('emergencyName') is-invalid @enderror" name="emergencyName" value="{{$record->emergencyName}}" required autocomplete="emergencyName">
                                @error('emergencyName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror       
                            </div>

                            <br>

                            <div class="mb-3 auto">
                                <label for="exampleInputEmail1" class="form-label bold pull-left">Contact Number</label>
                                <input type="text" class="form-control @error('emergencyNumber') is-invalid @enderror" name="emergencyNumber" value="{{$record->emergencyNumber}}" required autocomplete="emergencyNumber">
                                @error('emergencyNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror    
                            </div>

                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3 auto">
                                <label for="exampleInputEmail1" class="form-label bold pull-left">Address</label>
                                <textarea class="form-control @error('emergencyAddress') is-invalid @enderror" name="emergencyAddress" rows="2" required autocomplete="emergencyAddress">{{$record->emergencyAddress}}</textarea>
                                @error('emergencyAddress')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror    
                            </div>        
                        </div>

                    </div>
        
                    <br><hr><br>

                    <h4 class="text-center mb-5">Medical History</h4>
                        
                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Family History</label>
                        <textarea class="form-control @error('familyHistory') is-invalid @enderror" name="familyHistory" rows="3" required autocomplete="familyHistory">{{$record->familyHistory}}</textarea>
                        @error('familyHistory')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror                           
                    </div>

                    <br>

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Social History</label>
                        <textarea class="form-control @error('socialHistory') is-invalid @enderror" name="socialHistory" rows="3" required autocomplete="socialHistory">{{$record->socialHistory}}</textarea>
                        @error('socialHistory')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror  
                    </div>

                    <br>

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Medical History</label>
                        <textarea class="form-control @error('medicalHistory') is-invalid @enderror" name="medicalHistory" rows="3" required autocomplete="medicalHistory">{{$record->medicalHistory}}</textarea>
                        @error('medicalHistory')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror  
                    </div>
                
                    <br><hr><br>     

                    <h4 class="text-center mb-5">Current State</h4>

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Mental State</label>
                        <textarea class="form-control @error('currentMentalState') is-invalid @enderror" name="currentMentalState" rows="3" required autocomplete="currentMentalState">{{$record->currentMentalState}}</textarea>
                        @error('currentMentalState')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror  
                    </div>

                    <br>

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Medical Treatment</label>
                        <textarea class="form-control @error('currentMedicalTreatment') is-invalid @enderror" name="currentMedicalTreatment" rows="3" required autocomplete="currentMedicalTreatment">{{$record->currentMedicalTreatment}}</textarea>
                        @error('currentMedicalTreatment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror  
                    </div>

                    <br><hr><br>

                    <div class="d-flex bd-highlight">						
                        <div class="me-auto p-2 bd-highlight"></div>							
                        <div class="p-2 bd-highlight">
                            <button type="submit" class="btn btn-outline" onclick="return confirm('Save the changes?')">
                                Update
                            </button>								
                        </div>
                    </div>     
                </form>              

            </div> <!--here-->

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection

	






