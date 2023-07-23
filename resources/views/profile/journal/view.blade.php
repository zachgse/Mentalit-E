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
                
                <div class="d-flex justify-content-between">
                    <div class="p-2 bd-highlight">
                        <a href="/profile/journal/index">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>

                    <div class="p-2 bd-highlight">
                        <h4>View a journal entry</h4>
                    </div>

                    <div class="p-2 bd-highlight"></div>
                </div>


                <br><hr class="divider"><br>

                <div class="d-flex bd-highlight mb-3">
                    <div class="me-auto p-2 bd-highlight"></div>
                    <div class="p-2 bd-highlight"></div>
                    <div class="p-2 bd-highlight">
                        <b>Date: </b>{{$journal->journalDateTime}}
                    </div>
                </div>

                <br><hr><br>



                <h4 class="text-left ms-2">Subject: {{$journal->journalSubject}}</h4>
                <br><br>  
                <p class="text-left ms-5">{{$journal->journalDescription}}</p>

                <br><br><hr>        
                
            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection








