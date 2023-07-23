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
                <h4 class="text-center">Create your own post</h4>
            </div>

            <div class="p-2 bd-highlight"></div>
        </div>    

        <br><hr class="divider"><br>

        <form method="POST" action="/forum" >
            @csrf

            <div class="text-center">
                <label>Title</label>
                <input class="form-control w-75 auto @error('forumSubject') is-invalid @enderror" id="name" name="forumSubject" value="{{ old('forumSubject') }}" required autocomplete="forumSubject">
                @error('forumSubject')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror   
            </div>

            <br>

            <div class="text-center">
                <label>Category</label>
                <select name="forumCategory" type="text" class="form-control text-center w-75 auto mt-3 @error('description') is-invalid @enderror" required autocomplete="select type of report">
                    <option value="none" selected disabled hidden>-- Select type of category --</option>                          
                    <option value="Tips">Tips</option>
                    <option value="Practices">Practices</option>
                    <option value="Advice">Advice</option>
                    <option value="Habits">Habits</option>
                    <option value="Others">Others</option>
                </select>    
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror   
            </div>

            <br>

            <div class="text-center">
                <label>Content</label>
                <textarea class="form-control w-75 auto @error('forumComment') is-invalid @enderror" rows="4" name="forumComment" rows="8" name="forumComment" required autocomplete="forumComment" autofocus>{{ old('forumComment') }}</textarea>
                @error('forumComment')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror   
            </div>
            <br>

            <button class="btn btn-outline pull-right" type="submit" onclick="return confirm('Post the discussion?')">Submit</button>
        </form>

        <br>

    </div>
</div>

@endsection





