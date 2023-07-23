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
                    <form action="/profile/profile/updateimage" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input class="form-control w-25 m-auto mt-3 @error('profile_image') is-invalid @enderror" type="file" accept="image/*" name="profile_image"  required autocomplete="profile_image">
                        @error('profile_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                        <button type="submit" class="btn btn-outline mt-3" onclick="return confirm('Upload the photo?')">Upload</button>
                    </form>			
                </div>
                
                <br><hr><br>

                <div class="row">
                    <h4 class="text-center mb-5">General Information</h4>
                    <div class="col-lg-6">

                        <form action="/profile/profile/updateinfo" method="POST">		
                            @csrf
                            @method('PUT')
                            <div class="mb-3 w-75 auto">
                                <label for="exampleInputEmail1" class="form-label">First Name</label>
                                <input class="form-control @error('firstName') is-invalid @enderror" type="text"  name="firstName" value="{{$user->firstName}}" required autocomplete="firstName">	
                                @error('firstName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror   
                            </div>        
                            <div class="mb-3 w-75 auto">
                                <label for="exampleInputEmail1" class="form-label">Middle Name</label>
                                <input class="form-control @error('middleName') is-invalid @enderror" type="text" name="middleName" value="{{$user->middleName}}">	
                                @error('middleName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror   
                            </div>    
                            <div class="mb-3 w-75 auto">
                                <label for="exampleInputEmail1" class="form-label">Last Name</label>
                                <input class="form-control @error('lastName') is-invalid @enderror" type="text" name="lastName" value="{{$user->lastName}}" required autocomplete="lastName">	
                                @error('lastName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror   
                            </div>                           
                            <div class="mb-3 w-75 auto">
                                <label for="exampleInputEmail1" class="form-label">Contact Number</label>
                                <input type="text" class="form-control @error('contactNo') is-invalid @enderror" name="contactNo" value="{{$user->contactNo}}" required autocomplete="contactNo">
                                @error('contactNo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror   
                            </div>
                            <br>
                            <div class="mb-3 w-75 auto">
                                <label for="exampleInputEmail1" class="pull-left"><b>Birth Date: </b>{{ \Carbon\Carbon::parse($user->birthDate)->format('F j , Y')}}</label>
                            </div>        
                            <br><br>
                            <div class="mb-3 w-75 auto">
                                <label for="exampleInputEmail1" class="pull-left"><b>Gender: </b>{{$user->gender}}</label>
                            </div> 		                               																				
                    </div>
                    
                    <div class="col-lg-6">	
                            <div class="mb-3 w-75 auto">
                                <label for="exampleInputEmail1" class="form-label">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{$user->city}}" required autocomplete="city">
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror   
                            </div>	
                            <div class="mb-3 w-75 auto">
                                <label for="exampleInputEmail1" class="form-label">Barangay</label>
                                <input type="text" class="form-control @error('barangay') is-invalid @enderror" name="barangay" value="{{$user->barangay}}" required autocomplete="barangay">
                                @error('barangay')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror   
                            </div>           
                            <div class="mb-3 w-75 auto">
                                <label for="exampleInputEmail1" class="form-label">Street</label>
                                <input type="text" class="form-control @error('streetNumber') is-invalid @enderror" name="streetNumber" value="{{$user->streetNumber}}" required autocomplete="streetNumber">
                                @error('streetNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror   
                            </div>        
                            <div class="mb-3 w-75 auto">
                                <label for="exampleInputEmail1" class="form-label">Zip Code</label>
                                <input type="text" class="form-control @error('zipCode') is-invalid @enderror" name="zipCode" value="{{$user->zipCode}}" required autocomplete="zipCode">
                                @error('zipCode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror   
                            </div>    
                                            
                    </div>					
                </div>
                
                <br><hr><br>
                <div class="d-flex bd-highlight">
                    <div class="p-2 bd-highlight">
                    </div>
                    <div class="me-auto p-2 bd-highlight">
                    </div>					
                    <div class="p-2 bd-highlight">
                        <button type="submit" class="btn btn-outline" onclick="return confirm('Save the changes?')">Save changes</button>
                    </div>
                    </form>
                </div> 

                <br><hr><br>

            
                <h4 class="text-center mb-5">Security Information</h4>
                <a href="/profile/profile/change">
                    <button type="submit" class="btn btn-outline">Change Password</button>
                </a>
          
            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection


				




