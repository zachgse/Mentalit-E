@extends('layouts.app')
@section('content')

<div class="container">

    <div class="shadow-lg p-3 mb-5 rounded w-50 m-auto">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <div class="p-2 bd-highlight">
                <a href="/welcome">
                    <i class="fa fa-angle-left"></i>
                </a>
            </div>

            <div class="p-2 bd-highlight">
                <h4 class="text-center">Resubscribe for {{$clinic->clinicName}}</h4>
            </div>

            <div class="p-2 bd-highlight"></div>
        </div>    

        <br><hr class="divider"><br>

        <form method="POST" action="/resubscribe/store" enctype="multipart/form-data">
            @csrf   
            <div>
                <label><b>Packages available</b></label>
                <select name="subscription_id" type="text" class="form-control text-center mt-3 w-50 auto @error('subscription_id') is-invalid @enderror" required autocomplete="subscription_id">
                    <option value="none" selected disabled hidden>-- Extend your subscription --</option>  
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

            <br><br>

            <b>Payment</b>
            <div class="d-flex justify-content-center">
                <div class="d-flex p-2 bd-highlight"> 
                    <input class="form-control @error('paymentProof') is-invalid @enderror" type="file"  name="paymentProof" accept="image/*, application/pdf, application/docx, .doc, .docx" required autocomplete="paymentProof">
                    @error('paymentProof')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 
                </div>
	                
                <div class="d-flex p-2 bd-highlight">
                    <a class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#payment">Payment Info</a>
                    @include('inc.payment-instruct-modal')
                </div>        
            </div>     



            <br><br>

            <button class="btn btn-outline" type="submit">Submit</button>
        </form>

    </div>
</div>

@endsection





