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
                <a href="/profile/journal/index">
                    <i class="fa fa-angle-left"></i>
                </a>
            </div>

            <div class="p-2 bd-highlight">
                <h4 class="text-center">Create an entry</h4>
            </div>

            <div class="p-2 bd-highlight"></div>
        </div>    

        <br><hr class="divider"><br>

        <form method="POST" action="/profile/journal/store">
            @csrf
            <div class="mb-3 w-75 auto">
                <label class="form-label text-center bold">Journal Subject</label>
                <input type="text" class="form-control w-75 auto @error('journalSubject') is-invalid @enderror" name="journalSubject" value="{{ old('journalSubject') }}" required autocomplete="journalSubject">               
                @error('journalSubject')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </div>    
            
            <div class="mb-3 w-75 auto">
                <label class="form-label text-center bold">Journal Description</label>
                <textarea class="form-control w-75 auto @error('journalDescription') is-invalid @enderror" rows="4" name="journalDescription" required autocomplete="journalDescription" autofocus>{{ old('journalDescription') }}</textarea>        
                @error('journalDescription')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </div>    
            
            <br><br>
           
            <button class="btn btn-outline" type="submit" onclick="return confirm('Create a journal?')">Submit</button>

        </form>
    </div>
</div>

@endsection



