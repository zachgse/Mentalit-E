@extends('layouts.app')
@section('content')

<div class="container">

    <div class="shadow-lg p-3 mb-5 rounded w-50 m-auto">
        @if(session()->has('message'))
            <div class="alert alert-danger">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <div class="p-2 bd-highlight">
                <a href="/clinic/service/index">
                    <i class="fa fa-angle-left"></i>
                </a>
            </div>
            <div class="p-2 bd-highlight">
                <h4>Add a service</h4>
            </div>
            <div class="p-2 bd-highlight"></div>
        </div>

        <br><hr class="divider"><br>

        <form method="POST" action="/clinic/service" >
            @csrf
            <div>
                <label><b>Service Name</b></label>
                <input class="form-control w-50 auto @error('serviceName') is-invalid @enderror" name="serviceName" value="{{ old('serviceName') }}" required autocomplete="serviceName">
                @error('serviceName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <br>

            <div>
                <label><b>Service Description</b></label>
                <textarea class="form-control w-50 auto @error('serviceDescription') is-invalid @enderror" rows="5" name="serviceDescription" >{{ old('serviceDescription') }}</textarea>
                @error('serviceDescription')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <br>

            <div>
                <label><b>Service Price</b></label>
                <input class="form-control w-50 auto @error('servicePrice') is-invalid @enderror" name="servicePrice" value="{{ old('servicePrice') }}" required autocomplete="servicePrice">
                @error('servicePrice')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <br>

            <b>Date of booking available</b>
            <div class="d-flex bd-highlight justify-content-center">
				<div class="bd-highlight m-2">
					<input type="datetime-local" id="start" name="serviceStart" class="form-control @error('serviceStart') is-invalid @enderror" required autocomplete="serviceStart">
                @error('serviceStart')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>	
                <div class="bd-highlight m-2">
					to
				</div>		
				<div class="bd-highlight m-2">
					<input type="datetime-local" id="end" name="serviceEnd" class="form-control @error('serviceEnd') is-invalid @enderror" required autocomplete="serviceEnd">
                @error('serviceEnd')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>									
			</div>	

            <br>

            <div>
                <label><b>Length of service (Specify in hours)</b></label>
                <input type="number" min="0" max="12" class="form-control w-50 auto @error('serviceLength') is-invalid @enderror" value="{{ old('serviceLength') }}" name="serviceLength" required autocomplete="serviceLength">
                @error('serviceLength')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <br>            

            <button class="btn btn-outline" type="submit" onclick="return confirm('Add the service?')">Submit</button>
        </form>
    </div>
</div>

@endsection

