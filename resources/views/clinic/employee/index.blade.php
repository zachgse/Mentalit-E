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
                
                <h2 class="text-center">List of Employees</h2>

                <br><hr class="divider"><br>

                <div class="table-responsive-xl">
                    <table class="table table-bordered" id="employee-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>PRC License</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <thead class="plain">
                            <tr>
                                <th></th>
                                <th>
                                    <select data-column="1" type="text" class="text-center form-control filter-select pointer">
                                        <option value="">Filter</option>  
                                            @foreach($employee as $e)                       
                                                <option value="{{$e->userEmployee->lastName}}">
                                                    {{$e->userEmployee->lastName}}
                                                </option>
                                            @endforeach
                                    </select>
                                </th>
                                <th></th>
                                <th></th>
                                <th>
                                    <select data-column="4" type="text" class="text-center form-control filter-select pointer">
                                        <option value="" >Filter</option>                    
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </th>
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
    
    var table = $('#employee-table').DataTable({
        processing: true,
        serverside: true,
        responsive: true,
        ajax: "/clinic/employee/list",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, sortable : true, visible: true},
            {data: 'userName', name: 'userEmployee.lastName', searchable: true, sortable : true, visible: true},
            {data: 'userEmployee', name: 'userEmployee.userType', searchable: true, sortable : true, visible: true},
            {data: 'link', name: 'link', searchable: false, sortable : false, visible: true},
            {data: 'accountStatus', name: 'accountStatus', searchable: true, sortable : true, visible: true},
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
				




