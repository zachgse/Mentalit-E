@extends('layouts.app')

@section('content')
<div class="container">

    <div class="shadow-lg p-5 mb-5 rounded w-50 m-auto">


        <h4 class="text-center">{{ __('Reset Password') }}</h4>

        <br><hr class="divider"><br><br><br>


        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <br><br>

            <button type="submit" class="btn btn-outline m-auto">
                {{ __('Send Password Reset Link') }}
            </button>
      
        </form>
                
      
    </div>
</div>
@endsection


