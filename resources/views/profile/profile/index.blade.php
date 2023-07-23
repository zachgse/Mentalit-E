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

                <div class="text-center"> 
                    @if ($user->profile_image == null)  
                        <img src="{{ asset('storage/avatars/default.png')}}" class="rounded-circle" width="170" height="146">		
                    @else
                        <img src="{{ asset('storage/avatars/'.$user->profile_image) }}" class="rounded-circle" width="170" height="146">
                    @endif
                    <h4 class="mt-2"><b>{{ Auth::user()->firstName }} {{ Auth::user()->middleName }} {{ Auth::user()->lastName }}</b></h4>						
                </div>

                <br><hr><br>

                <div class="d-flex justify-content-start">
                    <div class="p-2 me-5 bd-highlight">			
                        <p class="text-left ms-3">
                            <b>Email Address</b>: {{ Auth::user()->email }}
                        </p>
                        <p class="text-left ms-3">                        
                            <b>Birth date</b>: {{ \Carbon\Carbon::parse(Auth::user()->birthDate)->format('F j , Y')}}
                        </p>
                        <p class="text-left ms-3">
                            <b>Gender</b>: {{ Auth::user()->gender }}
                        </p>	
                        <p class="text-left ms-3">
                            <b>Contact Number</b>: {{ Auth::user()->contactNo }}
                        </p>
                        <p class="text-left ms-3">
                            <b>Address</b>: {{ Auth::user()->barangay }} {{ Auth::user()->streetNumber }}
                                            {{ Auth::user()->city }} {{ Auth::user()->zipCode }}	
                        </p>								
                        <p class="text-left ms-3">
                            <b>Awards</b>: 
                            @forelse($award as $awards)
                                <img src="{{ asset($awards->getAward->awardImage)}}" width=30>		
                            @empty
                                None
                            @endforelse  
                        </p>							
                    </div>						
                </div>                


            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection

				






