@extends('layouts.app')
@section('content')
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif

<div class="container">
    <div class="shadow-lg p-5 mb-5 rounded w-75 m-auto">
        <h2 class="mb-5">Register your own clinic</h2>
        <hr class="divider"><br><br>

        <div class="row">
            
            <div class="col-lg-6">
            <form method="POST" action="/clinic/clinic" enctype="multipart/form-data">	
                @csrf
                <div class="mb-3 w-75 auto">
                    <label class="form-label pull-left">Subscription Package</label>
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
                </div>  
                                          
                <div class="mb-3 w-75 auto">
                    <label class="form-label pull-left">Clinic Name</label>
                    <input type="text" class="form-control @error('clinicName') is-invalid @enderror" name="clinicName" value="{{ old('clinicName') }}" required autocomplete="clinicName">
                    @error('clinicName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror   
                </div>
                <div class="mb-3 w-75 auto">
                    <label class="form-label pull-left">Clinic Description</label>
                    <textarea class="form-control @error('clinicDescription') is-invalid @enderror" name="clinicDescription" rows="4" required autocomplete="clinicDescription">{{ old('clinicDescription') }}</textarea>
                    @error('clinicDescription')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 
                </div>

                <div class="mb-3 w-75 auto">
                    <label class="form-label pull-left">Clinic Address</label>
                    <textarea class="form-control @error('clinicAddress') is-invalid @enderror" name="clinicAddress" rows="2" required autocomplete="clinicAddress">{{ old('clinicAddress') }}</textarea>
                    @error('clinicAddress')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 
                </div>	                             																				
            </div>
            
            <div class="col-lg-6">
                <div class="mb-3 w-75 auto">
                    <label class="form-label pull-left">Clinic Phone Number</label>
                    <input type="text" class="form-control @error('clinicNumber') is-invalid @enderror" value="{{ old('clinicNumber') }}" name="clinicNumber" required autocomplete="clinicNumber">
                    @error('clinicNumber')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 
                </div>	

                <div class="mb-3 w-75 auto">
                    <label class="form-label pull-left">BIR License (input expiry below)</label>
                    <input type="date" class="form-control mb-3 @error('birLicenseExpiry') is-invalid @enderror" name="birLicenseExpiry" required autocomplete="birLicenseExpiry">
                    <input class="form-control @error('birLicense') is-invalid @enderror" type="file" accept="image/*, application/pdf, application/msword, .doc, .docx" name="birLicense" required autocomplete="birLicense">			
                    @error('birLicense')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 	

                    @error('birLicenseExpiry')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 					
                </div>   
                                
                <div class="mb-3 w-75 auto">
                    <label class="form-label pull-left">PRC License</label>
                    <input class="form-control @error('prcLicense') is-invalid @enderror" type="file" accept="image/*, application/pdf, application/docx, .doc, .docx" name="prcLicense" required autocomplete="prcLicense">	
                    @error('prcLicense')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 						
                </div>

                <div class="mb-3 w-75 auto">
                    <label class="form-label pull-left">Proof of Payment</label>
                    <input class="form-control @error('paymentProof') is-invalid @enderror" type="file" accept="image/*, application/pdf, application/msword, .doc, .docx" name="paymentProof" required autocomplete="paymentProof">	
                    @error('paymentProof')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 						
                </div>          
                
                <div class="mb-3 w-75 auto mt-5">
                    <a class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#payment">Payment Info</a>
                    @include('inc.payment-instruct-modal')
                </div>                         
            </div>	

        </div>
    
            <br><hr><br>
            <div class="d-flex bd-highlight">

                <div class="me-auto p-2 bd-highlight"></div>					
                <div class="p-2 bd-highlight">
                    <button type="submit" class="btn btn-outline">Submit</button>
                </div>
            </form>


    </div>
</div>

<br><br>

@endsection

