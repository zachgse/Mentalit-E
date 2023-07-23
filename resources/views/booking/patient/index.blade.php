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
                <h2 class="text-center">List of booking</h2>

                <br><hr class="divider"><br>

                <div class="d-flex flex-row bd-highlight mb-5 pull-left">
                    <div class="p-2 bd-highlight">
                        <a href="/booking/quick">
                            <button class="btn btn-outline">Quick Booking</button>
                        </a>
                    </div>
                    <div class="p-2 bd-highlight">
                        <a href="/booking">
                            <button class="btn btn-outline">Manual Booking</button>
                        </a>                        
                    </div>
                </div>

                
                
                <div class="table-responsive-xl">
                    <table class="table table-bordered" id="patient-booking-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Clinic</th>
                                <th>Service</th>
                                <th>Booking Date</th>
                                <th>Status</th>
                                <th>Link</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <thead class="plain">
                            <tr>
                                <th></th>
                                <th>
                                    <select data-column="1" type="text" class="text-center form-control filter-select pointer">
                                        <option value="">Filter</option>  
                                            @foreach($clinic as $c)                       
                                                <option value="{{$c->clinicPatient->clinicName}}">
                                                    {{$c->clinicPatient->clinicName}}
                                                </option>
                                            @endforeach
                                    </select>
                                </th>
                                <th></th>
                                <th>
                                    <select data-column="3" type="text" class="text-center form-control filter-select pointer">
                                        <option value="" >Filter</option>                    
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>
                                    </select>
                                </th>
                                <th>
                                    <select data-column="4" type="text" class="text-center form-control filter-select pointer">
                                        <option value="" >Filter</option>                    
                                        <option value="To Pay">To Pay</option>
                                        <option value="To Cancel">To Cancel</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="To Rate">To Rate</option>
                                        <option value="Done">Done</option>
                                    </select>
                                </th>
                                <th></th>
                                <th></th>
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
    
    var table = $('#patient-booking-table').DataTable({
        buttons: ['Assign', 'View'],
        processing: true,
        serverside: true,
        responsive: true,
        ajax: "/booking/patient/list",
        columns: [ 
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, sortable : true, visible: true},
            {data: 'clinicBooking', name: 'clinicBooking.clinicName', searchable: true, sortable : true, visible: true},
            {data: 'serviceBooking', name: 'serviceBooking.serviceName', searchable: true, sortable : true, visible: true},
            {data: 'bookingDate', name: 'bookingDate', searchable: true, sortable : true, visible: true},
            {data: 'status', name: 'status', searchable: true, sortable : true, visible: true},
            {data: 'link', name: 'link', searchable: false, sortable : true, visible: true},
            {data: 'actions', name: 'actions', searchable: false, sortable : false, visible: true},
        ]       
    });

    $('.filter-select').change(function() {
        table.column( $(this).data('column'))
            .search( $(this).val())
            .draw();
    });
    
});
</script>
@endsection

				









