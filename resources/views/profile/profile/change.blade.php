@extends('layouts.app')
@section('content')

<div class="container">

    <div class="shadow-lg p-3 mb-5 rounded w-50 m-auto">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <div class="p-2 bd-highlight">
                <a href="/profile/profile/edit">
                    <i class="fa fa-angle-left"></i>
                </a>
            </div>

            <div class="p-2 bd-highlight">
                <h4 class="text-center">Change Password</h4>
            </div>

            <div class="p-2 bd-highlight"></div>
        </div>    

        <br><hr class="divider"><br>

        <form method="POST" action="/profile/profile/changepassword">
        @csrf
        @method('PUT')

            <div class="mb-3 w-75 auto">
                <label class="form-label text-center bold">Old Password</label>
                <input type="password" class="form-control w-75 auto @error('old-password') is-invalid @enderror" id="old-password" name="old-password" required autocomplete="old_password">      
                @error('old-password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror           
            </div>     

            <div class="mb-3 w-75 auto">
                <label class="form-label text-center bold">New Password</label>
                <input type="password" class="form-control w-75 auto @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="password">      
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror           
            </div>     

            <div class="mb-3 w-75 auto">
                <label class="form-label text-center bold">Confirm Password</label>
                <input type="password" class="form-control w-75 auto @error('password') is-invalid @enderror" id="password-confirm" name="password_confirmation">       
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror          
            </div>


            
            <br><br>
           
            <button class="btn btn-outline" type="submit" onclick="return confirm('Save the changes?')">Submit</button>

        </form>
    </div>
</div>

@endsection



