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
                <a href="/forum">
                    <i class="fa fa-angle-left"></i>
                </a>
            </div>

            <div class="p-2 bd-highlight">
                <h4 class="text-center">Report a post</h4>
            </div>

            <div class="p-2 bd-highlight"></div>
        </div>    

        <br><hr class="divider"><br>

        <form method="POST" action="/forum/{{$forum->id}}/warningForum/store" >
            @csrf
            <div>
                <label>Description</label>
                <select name="description" type="text" class="form-control text-center w-75 auto mt-3 @error('description') is-invalid @enderror" required autocomplete="select type of report">
                    <option value="none" selected disabled hidden>-- Select type of report --</option>                          
                    <option value="Hateful Speech">Hateful Speech</option>
                    <option value="Vulgar Words">Vulgar Words</option>
                    <option value="Discrimination">Discrimination</option>
                    <option value="Misinformation">Misinformation</option>
                    <option value="Others">Others</option>
                </select>    
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror   
            </div>

            <br>

            <button class="btn btn-outline" type="submit" onclick="return confirm('Report the user?')">Submit</button>
        </form>

    </div>
</div>

@endsection





