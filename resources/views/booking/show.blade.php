@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row border p-5 shadow-lg">

        <div class="d-flex justify-content-between">
            <div class="p-2 bd-highlight">
                <a href="/booking">
                    <i class="fa fa-angle-left"></i>
                </a>
            </div>
            <div class="p-2 bd-highlight"></div>
            <div class="p-2 bd-highlight"></div>
        </div>     
        
        <div class="col-lg-4">
        <br>
            @if ($clinic->clinicMainPhoto == null)  
                <img src="{{ asset('storage/avatars/hospital.png')}}" class="my-4 me-5 rounded" width="300" height="300">		
            @else
                <img src="{{ asset('storage/avatars/'.$clinic->clinicMainPhoto) }}" class="my-4 me-5 rounded" width="300" height="300">
            @endif	
        </div>
        
        <div class="col-lg-8 text-left">
            <h1 class="mt-5">{{$clinic->clinicName}}</h1>
            <br>
            <div class="d-flex bd-highlight mb-3">
                <div class="me-auto p-2 bd-highlight">
                    @for($i=1; $i<=$average; $i++) 
                        <span><i class="fa fa-star" style="font-size: 30px;"></i></span>
                    @endfor    
                    <p class="mt-1"><i>
                        {{$average}} stars out of 5 | Total of {{$booking_count}} booking/s conducted
                    </i></p>               
                </div>		
                <div class="p-2 bd-highlight">			
                    <a href="/booking/{{ $clinic->id }}/view">
                        <button type="submit" class="btn btn-outline">
                            View schedule
                        </button>	
                    </a>	
                </div>
            </div>			
            <br>
            <p class="w-75">
                {{$clinic->clinicDescription}}		
            </p>
            <br>
            <div class="d-flex justify-content-start">
                <div class="p-2 me-5 bd-highlight">
                    <h4>Services offer</h4>
                    <ul>
                        @foreach ($clinic->clinicService as $service)
                        <li>{{$service->serviceName}}</li>		
                        @endforeach
                    </ul>
                </div>
                <div class="p-2 me-5 bd-highlight">			
                    <h4>Location</h4>
                    <p>- {{$clinic->clinicAddress}}</p>
                </div>		
                <div class="p-2 bd-highlight">			
                    <h4>Price Range</h4>
                    <p>- ₱{{$price}}</p>	
                </div>			
                		
            </div>			
        
        </div>
        
        <div class="col-lg-12 mt-5 text-left">
            <h4 class="mb-5">Ratings ({{$rating_count}})</h4>
            
            @forelse($clinic->clinicRating as $rating)
            <div class="d-flex justify-content-start">
                <div class="p-2 me-3 ms-3 bd-highlight">
                @if ($rating->userRating->profile_image == null)  
                    <img src="{{asset('img/user.png')}}" class="rounded-circle ms-3" width="80" height="76">	
                @else
                    <img src="{{ asset('storage/avatars/'.$rating->userRating->profile_image) }}" class="rounded-circle ms-3" width="80" height="76">
                @endif	                 
                </div>
                <div class="p-2 me-auto bd-highlight">			
                    <h5> {{$rating->userRating->firstName}} {{$rating->userRating->lastName}}</h5> 
                    <i>
                        {{$rating->bookingRating->serviceBooking->serviceName}}
                        (
                            @for($i=1; $i<=$rating->starRating; $i++) 
                                <span><i class="fa fa-star"></i></span>
                            @endfor
                        )
                    </i>
                    <p class="w-100 ms-3 mt-2">
                        {{$rating->ratingDescription}}		
                    </p>
                </div>		
                <div class="p-2 bd-highlight">
                    <i>{{ \Carbon\Carbon::parse($rating->dateTime)->format('F j , Y  h:i A')}}</i>
                </div>				
            </div>	
            <hr>
            @empty 
            <div class="d-flex justify-content-start">
                <p class="text-center">No ratings yet</p>
            </div>	
            @endforelse
            	
        
        </div>

    </div>

</div>
<br><br><br><br>

@endsection




