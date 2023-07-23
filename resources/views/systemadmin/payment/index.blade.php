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
                
                <h2 class="text-center">List of payments</h2>

                <br><hr class="divider"><br>

                <div class="table-responsive-xl">
                    <table class="table table-bordered" id="payment-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Clinic Name</th>
                                <th>Email Address</th>
                                <th>Package availed</th>
                                <th>Proof</th>
                                <th>Date</th>
                                <th>Status</th>
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
    
    $('#payment-table').DataTable({
        processing: true,
        serverside: true,
        responsive: true,
        "scrollX": true,
        ajax: "/systemadmin/payment/list",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, sortable : true, visible: true},
            {data: 'clinicName', name: 'clinicName', searchable: true, sortable : true, visible: true},
            {data: 'clinicAddress', name: 'clinicAddress', searchable: true, sortable : true, visible: true},
            {data: 'subscription_id', name: 'subscription_id', searchable: true, sortable : true, visible: true},
            {data: 'paymentProof', name: 'paymentProof', searchable: false, sortable : false, visible: true},
            {data: 'paymentDateTime', name: 'paymentDateTime', searchable: true, sortable : true, visible: true},
            {data: 'paymentStatus', name: 'paymentStatus', searchable: true, sortable : true, visible: true},
            {data: 'actions', name: 'actions', searchable: false, sortable : false, visible: true},
        ]       
    });
    
});
</script>
@endsection
				




