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
            
            @if(session()->has('negative'))
                <div class="alert alert-danger">
                    {{ session()->get('negative') }}
                </div>
            @endif  

            <div class="shadow p-5 w-100 standard">
                
                <div class="d-flex justify-content-between">
                    <div class="p-2 bd-highlight">
                        <a href="/clinic/booking/index">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>

                    <div class="p-2 bd-highlight">
                        <h2>Assign booking</h2>
                    </div>

                    <div class="p-2 bd-highlight"></div>
                </div>

                <br><hr class="divider"><br>

                <div class="table-responsive-xl">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($temp as $employee)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $employee->userEmployee->lastName }} , {{ $employee->userEmployee->firstName }}, {{ $employee->userEmployee->middleName }}</td>
                                <td>{{ $employee->userEmployee->userType }}</td>
                                <td>
                                    {{ $employee->accountStatus }}
                                </td>
                                <td>
                                    <div class="p-2 bd-highlight">    
                                        <form method="POST" action="/clinic/booking/{{$booking->id}}/view/{{$employee->id}}">
                                        @csrf
                                        @method('PUT')
                                            <button type="submit" class="btn btn-outline" onclick="return confirm('Assign the booking to this employee?')">
                                                Assign
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <h4>No employees available</h4>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection

				






