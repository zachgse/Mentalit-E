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

                <div class="d-flex justify-content-between">
                    <div class="p-2 bd-highlight">
                        <a href="/clinic/record/{{$patient->id}}/view">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>

                    <div class="p-2 bd-highlight">
                        <h4>Patient Booking History</h4>
                    </div>

                    <div class="p-2 bd-highlight"></div>
                </div>

                <br><hr class="divider"><br>

                <div class="table-responsive-xl">
                    <table class="table table-bordered" id="patient-booking-history-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Service</th>
                                <th>Booking Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($temp as $booking)   
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$booking->serviceBooking->serviceName}}
                                <td>
                                    {{ \Carbon\Carbon::parse($booking->start)->format('F j , Y  h:i A')}} to 
                                    {{ \Carbon\Carbon::parse($booking->end)->format('F j , Y  h:i A')}}
                                </td>
                                <td>{{$booking->status}}</td>
                                <td>
                                    <a href="/clinic/booking/{{$booking->id}}/display">
                                        <button type="submit" class="btn btn-outline">View</button>
                                    </a>
                                </td>
                            </tr>           
                            @endforeach
                        </tbody>
                    </table>     
                </div>           

            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection



				











	






