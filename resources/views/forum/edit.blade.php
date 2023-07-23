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
                <h4 class="text-center">Edit your own post</h4>
            </div>

            <div class="p-2 bd-highlight"></div>
        </div>    

        <br><hr class="divider"><br>

        <form method="POST" action="/forum/{{$forum->id}}" >
            @csrf
            @method('PUT')
            <div>
                <label>Title</label>
                <input class="form-control w-75 auto @error('forumSubject') is-invalid @enderror" id="name" name="forumSubject" value="{{$forum->forumSubject}}">
                @error('forumSubject')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror   
            </div>

            <br>

            <div>
                <label>Content</label>
                <textarea class="form-control w-75 auto @error('forumComment') is-invalid @enderror" rows="8" name="forumComment">{{$forum->forumComment}}</textarea>
                @error('forumComment')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror   
            </div>
            <br>

            <button class="btn btn-outline" type="submit" onclick="return confirm('Update the discussion?')">Submit</button>
        </form>

    </div>
</div>

@endsection





