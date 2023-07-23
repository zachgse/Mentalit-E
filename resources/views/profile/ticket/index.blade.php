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
                
                <h2 class="text-center">List of tickets</h2>

                <br><hr class="divider"><br>

                <div class="d-flex bd-highlight mb-3">
                    <div class="me-auto p-2 bd-highlight">
                        <a href="/profile/ticket/create">
                            <button type="submit" class="btn btn-outline">File a ticket</button>
                        </a>
                    </div>
                </div>	

                <br>

                <div class="table-responsive-xl">
                    <table class="table table-bordered" id="user-ticket-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Category</th>
                                <th>Date Issued</th>
                                <th>Date Resolved</th>
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
    
    $('#user-ticket-table').DataTable({
        processing: true,
        serverside: true,
        responsive: true,

        ajax: "/profile/ticket/list",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, sortable : true, visible: true},
            {data: 'ticketSubject', name: 'ticketSubject', searchable: true, sortable : true, visible: true},
            {data: 'ticketCategory', name: 'ticketCategory', searchable: true, sortable : true, visible: true},
            {data: 'dateTimeIssued', name: 'dateTimeIssued', searchable: true, sortable : true, visible: true},
            {data: 'dateTimeResolved', name: 'dateTimeResolved', searchable: true, sortable : true, visible: true},
            {data: 'ticketStatus', name: 'ticketStatus', searchable: true, sortable : true, visible: true},
            {data: 'actions', name: 'actions', searchable: false, sortable : false, visible: true},
        ]       
    });
    
});
</script>
@endsection
				




