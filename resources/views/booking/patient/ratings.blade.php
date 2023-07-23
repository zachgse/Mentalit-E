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
                        <a href="/booking/patient/index">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>

                    <div class="p-2 bd-highlight">
                        <h4>Rate Booking</h4>
                    </div>

                    <div class="p-2 bd-highlight"></div>
                </div>

                <br><hr class="divider"><br><br>

                <div class="row">

                    <div class="col-lg-6 text-left">
                        <b>Patient name: </b> {{$booking->userBooking->lastName}}, 
                        {{$booking->userBooking->firstName}} {{$booking->userBooking->middleName}}
                        <br><br>
                        <b>Clinic: </b> 
                        {{$booking->clinicBooking->clinicName}}
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

                @if($booking->status == "To Rate")
                  
                <form action="/booking/patient/{{$booking->id}}" method="post">
                    @csrf

                    <div class="stars">
                        <input class="star star-5" id="star-5" type="radio" name="starRating" value="5"/>
                            <label class="star star-5" for="star-5"></label>
                        <input class="star star-4" id="star-4" type="radio" name="starRating" value="4"/>
                            <label class="star star-4" for="star-4"></label>
                        <input class="star star-3" id="star-3" type="radio" name="starRating" value="3"/>
                            <label class="star star-3" for="star-3"></label>
                        <input class="star star-2" id="star-2" type="radio" name="starRating" value="2"/>
                            <label class="star star-2" for="star-2"></label>
                        <input class="star star-1" id="star-1" type="radio" name="starRating" value="1"/>
                            <label class="star star-1" for="star-1"></label>
                    </div>                    

                    <div class="mb-3 w-100 auto">
                        <label for="exampleInputEmail1" class="form-label bold pull-left">Comments / Suggestions: </label>
                        <textarea class="form-control @error('ratingDescription') is-invalid @enderror" name="ratingDescription" rows="4" required autocomplete="ratingDescription">{{ old('ratingDescription') }}</textarea>
                        @error('ratingDescription')
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

				






