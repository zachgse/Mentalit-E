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
                        <a href="/clinic/booking/index">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>

                    <div class="p-2 bd-highlight">
                        <h2>Edit link</h2>
                    </div>

                    <div class="p-2 bd-highlight"></div>
                </div>

                <br><hr class="divider"><br>

                @if($booking->link == null)
                <form action="/clinic/booking/{{$booking->id}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 w-75 auto">
                        <p><i>Insert the link below</i></p>
                        <input type="text" class="form-control w-75 auto mt-5" name="link">
                    </div>

                    <button type="submit" class="btn btn-outline" onclick="return confirm('Add the link?')">
                        Add
                    </button>
                </form>
                @else
                <form action="/clinic/booking/{{$booking->id}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 w-75 auto">
                        <p><i>Edit the link below</i></p>
                        <input type="text" class="form-control w-75 auto mt-5" name="link" value="{{$booking->link}}">
                    </div>

                    <button type="submit" class="btn btn-outline" onclick="return confirm('Update the link?')">
                        Update
                    </button>
                </form>
                @endif


            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection

				






