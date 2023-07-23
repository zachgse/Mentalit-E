@extends('layouts.app')
@section('content')

<div class="container">
    
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

        <div class="p-2 bd-highlight"></div>

        <div class="p-2 bd-highlight"></div>
    </div> 

    <br>

    <div class="card mb-3 p-5 forum-comment-view">
        <div class="d-flex justify-content-end">
            <i>{{ \Carbon\Carbon::parse($forum->dateTime)->format('F j , Y  h:i A')}}</i>  
            @if (auth()->user()->id != $forum->user_id)
            <a href="/forum/{{$forum->id}}/warningForum" class="text-decoration-none text-black">
                <img src="{{asset('img/report.png')}}" class="ms-3" width=20>
            </a>
            @endif
        </div>
        <div class="row no-gutters">
            <div class="col-lg-1 mt-3">
            @if($forum->userForum->profile_image == null)
                <img src="{{asset('img/user.png')}}" class="rounded-circle" width="80" height="76">	    
            @else       
                <img src="{{ asset('storage/avatars/'.$forum->userForum->profile_image) }}" class="rounded-circle" width="80" height="76">  
            @endif  
            </div>
            <div class="col-lg-11">
                <div class="card-body text-left">
                    <h4>{{$forum->forumSubject}}</h4>
                    <p><i><b>by {{$forum->userForum->firstName}}</b></i></p> 
                    <p>{{$forum->forumComment}}</p>
                </div>
            </div>
        </div>
    </div>

    <br><br>

    <div class="row border p-5 shadow-lg">
        <h4 class="text-left mb-3">Add a comment</h4>

        <form method="POST" action="/forum/{{$forum->id}}">
        @csrf
        <textarea class="form-control @error('forumCommentContent') is-invalid @enderror" rows="4" name="forumCommentContent" required autocomplete="forumCommentContent">{{ old('forumCommentContent') }}</textarea>
            @error('forumCommentContent')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror   
        <div class="d-flex bd-highlight">
  
            <div class="me-auto p-2 bd-highlight"></div>

            <div class="p-2 bd-highlight">		
                <button type="submit" class="btn btn-outline ms-auto mt-2" onclick="return confirm('Post the comment?')">Submit</button>
            </div>
        </form>
        </div>	
    </div>

    <br><br>

    <div class="row border p-5 shadow-lg">
        <h4 class="text-left mb-3">Comments</h4>
        @forelse ($comments as $comment)
            @if($comment->user_id == $user->id)
            <div class="card mb-3 p-5 forum-comment-view">
                <div class="d-flex justify-content-start">
                    <i>{{ \Carbon\Carbon::parse($comment->dateTime)->format('F j , Y  h:i A')}}</i>  
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-11">
                        <div class="card-body text-right">
                        <h5>{{$comment->userForumComment->firstName}}</h5> 
                            <p>
                                {{$comment->forumCommentContent}}                                 			
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-1">
                    @if($comment->userForumComment->profile_image == null)
                        <img src="{{asset('img/user.png')}}" class="rounded-circle" width="80" height="76">	    
                    @else       
                        <img src="{{ asset('storage/avatars/'.$comment->userForumComment->profile_image) }}" class="rounded-circle" width="80" height="76">  
                    @endif  
                    </div>
                </div>
            </div>
            @else
            <div class="card mb-3 p-5 forum-comment-view">
                <div class="d-flex justify-content-end">
                    <i>{{ \Carbon\Carbon::parse($comment->dateTime)->format('F j , Y  h:i A')}}</i>  
                    <a href="/forum/{{$comment->id}}/warningForumComment" class="text-decoration-none text-black">
                        <img src="{{asset('img/report.png')}}" class="ms-3" width=20>
                    </a>
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-1">
                    @if($comment->userForumComment->profile_image == null)
                        <img src="{{asset('img/user.png')}}" class="rounded-circle" width="80" height="76">	    
                    @else       
                        <img src="{{ asset('storage/avatars/'.$comment->userForumComment->profile_image) }}" class="rounded-circle" width="80" height="76">  
                    @endif  
                    </div>
                    <div class="col-lg-11">
                        <div class="card-body text-left">
                        <h5>{{$comment->userForumComment->firstName}}</h5> 
                            <p>
                                {{$comment->forumCommentContent}}                                 			
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif	
        @empty
        <div class="row border p-5 shadow-sm mb-3">
            <p class="text-center">No comments yet</p>
        </div>
        @endforelse
    </div>

</div>

<br><br>
@endsection