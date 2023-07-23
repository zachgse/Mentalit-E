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

                <h2 class="text-center">List of assigned bookings</h2>

                <br><hr class="divider"><br>

                <div class="table-responsive-xl">
                    <table class="table table-bordered" id="employee-booking-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Patient Name</th>
                                <th>Service</th>
                                <th>Booking Date</th>
                                <th>Status</th>
                                <th>Link</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table> 
                </div> 

            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection

@section('scripts')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
$(function () {
    
    $('#employee-booking-table').DataTable({
        buttons: ['Assign', 'View'],
        processing: true,
        serverside: true,
        responsive: true,
        ajax: "/booking/employee/list",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, sortable : true, visible: true},
            {data: 'userBooking', name: 'userBooking.lastName', searchable: true, sortable : true, visible: true},
            {data: 'serviceBooking', name: 'serviceBooking.serviceName', searchable: true, sortable : true, visible: true},
            {data: 'bookingDate', name: 'bookingDate', searchable: true, sortable : true, visible: true},
            {data: 'status', name: 'status', searchable: true, sortable : true, visible: true},
            {data: 'link', name: 'link', searchable: false, sortable : true, visible: true},
            {data: 'actions', name: 'actions', searchable: false, sortable : false, visible: true},
        ]       
    });
    
});
</script>
@endsection

				









