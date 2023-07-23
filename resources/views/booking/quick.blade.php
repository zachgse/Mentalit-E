@extends('layouts.app')
@section('content')

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="container">
    <div class="shadow-lg p-3 mb-5 rounded w-50 m-auto">
    <br>
    <h4 class="text-center">Quick Booking</h4>


    <br><hr class="divider"><br>
 
        @foreach ($services as $service)
        <div class="shadow p-2 text-left">	
            <b>{{$service->clinicService->clinicName}}</b><br>
            <b>{{$service->serviceName}}</b><br>
            {{$service->serviceDescription}}<br>								
            ₱<i>{{$service->servicePrice}}</i><br>
            <a href="/booking/{{$service->id}}/displayquick" class="text-decoration-none">
                <button type="submit" class="btn btn-outline pull-right">Schedule</button>
            </a>
            <br><br>
        </div>
        <br>	
        @endforeach

        <nav aria-label="Page navigation example">
            <ul class="pagination pull-right mt-5">
                <li class="page-item">{{ $services->links() }}</li>
            </ul>
        </nav>
    </div>
</div>

@endsection

