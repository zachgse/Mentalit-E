@extends('layouts.app')
@section('content')

<div class="container">
    <div class="shadow-lg p-3 mb-5 rounded w-50 m-auto">
    <br>

        <div class="d-flex justify-content-between">
            <div class="p-2 bd-highlight">
                <a href="/booking/{{ $clinic->id }}/show">
                    <i class="fa fa-angle-left"></i>
                </a>
            </div>
            <div class="p-2 bd-highlight">
                <h4 class="text-center">Services offered by {{$clinic->clinicName}}</h4>
            </div>
            <div class="p-2 bd-highlight"></div>
        </div>    

        <br><hr class="divider"><br>
 
        @foreach ($clinic->clinicService as $service)
        <div class="shadow p-2 text-left">	
            <b>{{$service->serviceName}}</b><br>
            {{$service->serviceDescription}}<br>								
            <i>₱{{$service->servicePrice}}</i> <br>
            <a href="/booking/{{ $clinic->id }}/{{$service->id}}/display">
                <button type="submit" class="btn btn-outline pull-right">
                    Schedule
                </button>
            </a>
            <br><br>
        </div>
        <br>	
        @endforeach
    </div>
</div>

@endsection

