@extends('layouts.app')
@section('content')

<div class="container">

    <div class="shadow-lg p-3 mb-5 rounded w-50 m-auto">
    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
    <br>
        <div class="d-flex justify-content-between">
            <div class="p-2 bd-highlight">
                <a href="/booking/{{$clinic->id}}/view">
                    <i class="fa fa-angle-left"></i>
                </a>
            </div>

            <div class="p-2 bd-highlight">
                <h4 class="text-center">Book {{$service->serviceName}}</h4>
            </div>

            <div class="p-2 bd-highlight"></div>
        </div>    

        <br><hr class="divider"><br>

        <form method="POST" action="/booking/{{$clinic->id}}/{{$service->id}}/display" enctype="multipart/form-data">
            @csrf
            <div>
                <p><b>Service Name:</b> {{$service->serviceName}}</p>
            </div>

            <div>
                <p><b>Service Description:</b> {{$service->serviceDescription}}</p>
            </div>

            <div>
                <p><b>Service Price:</b>₱ {{$service->servicePrice}} </p>
            </div>

            <div>
                <p><b>Service Length:</b> {{$service->serviceLength}} hours</p>
            </div>            

            <b>Date of booking available <br></b> <i>{{$temp}} <br> to <br> {{$temp2}}</i>
            <div class="d-flex bd-highlight justify-content-center">
				<div class="bd-highlight m-2">
                    <input type="datetime-local" name="start" class="form-control @error('start') is-invalid @enderror" 
                    min="{{$start}}" max="{{$end}}"  required autocomplete="start">
                    @error('start')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
				</div>										
			</div>

            <br>
            
            <b>Payment</b>
            <div class="d-flex justify-content-center">
                <div class="d-flex p-2 bd-highlight">            
                    <input class="form-control auto @error('payment') is-invalid @enderror" accept="image/*, application/pdf, application/msword, .doc, .docx" type="file"  name="payment">
                    @error('payment')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>                
                <div class="d-flex p-2 bd-highlight">
                    <a class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#payment">Payment Info</a>
                    @include('inc.clinic-modal')
                </div>        
            </div>

            <br>            
           
            <div class="w-50 auto">
                <input type="checkbox" name="consent" value="1" required> 
                I give my consent for processing my confidential data
            </div>
    
            <br>

            <button class="btn btn-outline" type="submit" onclick="return confirm('Book the schedule?')">Book</button>
        </form>
    </div>
</div>

@endsection



