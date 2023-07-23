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
                    <form action="/clinic/clinic/{{$clinic->id}}/picture" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input class="form-control w-25 m-auto mt-3 @error('clinicMainPhoto') is-invalid @enderror" type="file" name="clinicMainPhoto" accept="image/*" required autocomplete="clinicMainPhoto"> 
                        @error('clinicMainPhoto')
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
                        <form method="POST" action="/clinic/clinic/{{$clinic->id}}/info"> 
                        @csrf
                        @method('PUT')

                        <div class="mb-3 w-75 auto">
                            <label for="exampleInputEmail1" class="form-label bold">Clinic Name</label>
                            <input type="text" class="form-control @error('clinicName') is-invalid @enderror" name="clinicName" value="{{$clinic->clinicName}}" required autocomplete="clinicName">
                            @error('clinicName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   	
                        </div>

                        <div class="mb-3 w-75 auto">
                            <label for="exampleInputEmail1" class="form-label bold">Clinic Description</label>
                            <textarea class="form-control @error('clinicDescription') is-invalid @enderror" name="clinicDescription" rows="4" required autocomplete="clinicDescription">{{$clinic->clinicDescription}}</textarea>
                            @error('clinicDescription')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   
                        </div>

                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3 w-75 auto">
                            <label for="exampleInputEmail1" class="form-label bold">Clinic Address</label>
                            <textarea class="form-control @error('clinicAddress') is-invalid @enderror" name="clinicAddress" rows="2" required autocomplete="clinicAddress">{{$clinic->clinicAddress}}</textarea>
                            @error('clinicAddress')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   
                        </div>


                        <div class="mb-3 w-75 auto">
                            <label for="exampleInputEmail1" class="form-label bold">Clinic Number</label>
                            <input type="text" class="form-control @error('clinicNumber') is-invalid @enderror" name="clinicNumber" value="{{$clinic->clinicNumber}}" required autocomplete="clinicNumber">
                            @error('clinicNumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   
                        </div>            
                    </div>
                </div>

                <div class="d-flex bd-highlight">
                    <div class="p-2 bd-highlight"></div>
                    <div class="me-auto p-2 bd-highlight"></div>					
                    <div class="p-2 bd-highlight">
                        <button type="submit" class="btn btn-outline" onclick="return confirm('Save the changes?')">Update</button>
                    </div>
                </div>	
                </form>
                <br><hr><br>

                <h4 class="text-center mb-5">Payment Information</h4>
                <form action="/clinic/clinic/{{$clinic->id}}/payment" method="post">
                    @csrf
                    @method('PUT')
                    <textarea class="form-control @error('clinicPaymentInfo') is-invalid @enderror" name="clinicPaymentInfo" rows="6"  required autocomplete="clinicPaymentInfo">
                        @if($clinic->clinicPaymentInfo == null)
                            
                        @else
                            {{$clinic->clinicPaymentInfo}}
                        @endif
                    </textarea>

                    @error('clinicPaymentInfo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror   
                    <div class="d-flex bd-highlight mt-3">
                        <div class="p-2 bd-highlight"></div>
                        <div class="me-auto p-2 bd-highlight"></div>					
                        <div class="p-2 bd-highlight">
                            <button type="submit" class="btn btn-outline" onclick="return confirm('Save the changes?')">Update</button>
                        </div>
                    </div> 
                </form>
            
                <br><hr><br>     

                <div class="row">
                    <h4 class="text-center mb-5">Document Information</h4>
                    <div class="col-lg-6">
                        <div class="mb-3 w-75 auto">
                            <form action="/clinic/clinic/{{$clinic->id}}/license" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')                    
                                <label class="form-label pull-left bold">BIR License :  </label>  Expires on {{$clinic->birLicenseExpiry}}
                                <br><br>
                                <p class="text-left">
                                    Note: If you wish to update your license, input expiry date and attach the image below
                                </p>
                                <input type="date" class="form-control mb-3 @error('birLicenseExpiry') is-invalid @enderror" name="birLicenseExpiry" required autocomplete="birLicenseExpiry">
                                <input class="form-control @error('birLicense') is-invalid @enderror" type="file" name="birLicense" accept="image/*, application/pdf, application/msword" required autocomplete="birLicense" >
                                @error('birLicenseExpiry')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror  		
                                
                                @error('birLicense')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror  
                                <div class="d-flex justify-content-center">
                                    <div>                    
                                        <button type="submit" class="btn btn-outline mt-3 me-auto" onclick="return confirm('Update the BIR License?')">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>            
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3 w-75 auto">
                            <form action="/clinic/clinic/{{$clinic->id}}/subscription" method="post" enctype="multipart/form-data">
                                @csrf
                                <label for="exampleInputEmail1" class="form-label bold">Days left for subscription</label>
                                <br> {{$clinic->subscriptionDuration}} days
                                <select name="subscription_id" type="text" class="text-center form-control text-center @error('subscription_id') is-invalid @enderror" required autocomplete="subscription_id">
                                    <option value="none" selected disabled hidden>-------- Select Type of Subscription ---------</option>  
                                    @foreach($subscriptions as $subscription)                           
                                        <option value="{{$subscription->id}}">
                                            {{$subscription->subName}} - Php {{$subscription->subPrice}} ({{$subscription->subLength}} days)
                                        </option>
                                    @endforeach
                                </select>        
                                @error('subscription_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The subscription package is required</strong>
                                    </span>
                                @enderror   
                                <input class="form-control m-auto mt-3  @error('paymentProof') is-invalid @enderror" type="file" accept="image/*, application/pdf, application/msword" name="paymentProof" required autocomplete="paymentProof">
                                @error('paymentProof')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror  
                                <div class="d-flex justify-content-center mt-3">
                                    <div class="me-auto">
                                        <a class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#payment">Payment Info</a>
                                        @include('inc.payment-instruct-modal')
                                    </div>        
                                <div>            
                                        <button type="submit" class="btn btn-outline" onclick="return confirm('Avail the new package?')">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>            
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection

				




