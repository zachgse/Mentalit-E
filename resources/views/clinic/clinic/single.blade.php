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
                <div class="text-center">	
                    @if ($clinic->clinicMainPhoto == null)  
                        <img src="{{ asset('storage/avatars/hospital.png')}}" class="rounded-circle" width="170" height="146">		
                    @else
                        <img src="{{ asset('storage/avatars/'.$clinic->clinicMainPhoto) }}" class="rounded-circle" width="170" height="146">
                    @endif
                    <h4 class="mt-2"><b>{{$clinic->clinicName}}</b></h4>						
                </div>

                <br><hr><br>
                <div class="d-flex justify-content-start">
                    <div class="p-2 me-5 bd-highlight">	         	
                        <p class="text-left ms-3">
                            <b>Clinic Description</b>: {{$clinic->clinicDescription}}
                        </p>	
                        <p class="text-left ms-3">
                            <b>Contact Number</b>: {{$clinic->clinicNumber}}
                        </p>
                        <p class="text-left ms-3">
                            <b>Address</b>: {{$clinic->clinicAddress}}	
                        </p>									
                        <p class="text-left ms-3">
                            <b>Rating</b>: 
                        @if ($average == null)
                           No Ratings Yet
                        @else
                            @for($i=1; $i<=$average; $i++) 
                                <span><i class="fa fa-star" style="font-size: 30px;"></i></span>
                            @endfor 
                        @endif
                        </p>	
                    </div>						
                </div>

            </div>	

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection



				







