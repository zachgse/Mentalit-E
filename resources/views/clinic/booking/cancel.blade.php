@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">

        @include('inc.clinic')		

        <div class="col-lg-9">

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif         

            <div class="shadow p-5 w-100 standard">
                
                <div class="d-flex justify-content-between">
                    <div class="p-2 bd-highlight">
                        <a href="/booking/patient/index">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>

                    <div class="p-2 bd-highlight">
                        <h4>Cancel Booking</h4>
                    </div>

                    <div class="p-2 bd-highlight"></div>
                </div>

                <br><hr class="divider"><br><br>

                <div class="row">

                    <div class="col-lg-6 text-left">
                        <b>Patient name: </b> {{$booking->userBooking->lastName}}, 
                        {{$booking->userBooking->firstName}} {{$booking->userBooking->middleName}}
                        <br><br>
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

                @if($booking->status != "To Cancel")
                  
                <form action="/clinic/booking/{{$booking->id}}" method="post">
                    @csrf
                    @method('DELETE')
                                

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Reason: </label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" name="reason" rows="4" required autocomplete="reason">{{ old('reason') }}</textarea>
                        @error('reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <br><hr><br>
                    <div class="d-flex bd-highlight">

                        <div class="me-auto p-2 bd-highlight"></div>					
                        <div class="p-2 bd-highlight">
                            <button type="submit" class="btn btn-outline">Submit</button>
                        </div>

                </form>
                @endif


    
            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection

				






