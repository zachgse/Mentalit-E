@extends('layouts.app')
@section('content')

<div class="container mt-5">
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
    <h1 class="text-center">Mentalit-E Community Forum</h1>
	<br><hr class="divider"><br>
	<div class="d-flex bd-highlight mb-3">
	
		<div class="p-2 me-auto bd-highlight">
            <a href="/forum/create">
			    <button type="submit" class="btn btn-outline">Add new post</button>
            </a>
		</div>

		<div class="p-2 bd-highlight">
            <form action="/forum/search" method="post">
                @csrf
                <input type="search" name="query" class="form-control-md p-2" placeholder="Search...">
                <button class="btn btn-search m-0" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>
		</div>

	</div>	



    <div class="d-flex bd-highlight mb-3">

        <div class="me-auto"></div>

        <div class="p-2 bd-highlight">
            <form action="/forum/category" method="post">
                @csrf
                <select name="query" type="search"  class="text-center form-control-md pointer p-2 filter-forum">
                    <option value="" >Filter Tags</option>                    
                    <option value="Tips">Tips</option>
                    <option value="Practices">Practices</option>
                    <option value="Advice">Advice</option>
                    <option value="Habits">Habits</option>
                    <option value="Others">Others</option>
                </select>
                <button class="btn btn-search m-0" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>    
    </div>

	<br><br><br>

    <div class="row w-75 auto mt-5">

        @forelse ($searched_items as $forum)
            <div class="col-lg-6 mb-3 d-flex align-items-stretch text-left forum">
                <div class="card rounded-0 no-style shadow-lg">
                    <div class="card-body d-flex flex-column p-3">
                        <div class="d-flex justify-content-start">
                            <div class="p-2 me-5 bd-highlight">
                                @if ($forum->userForum->profile_image == null)  
                                    <img src="{{ asset('storage/avatars/default.png')}}" class="rounded-circle ms-3" width="80" height="76">		
                                @else
                                    <img src="{{ asset('storage/avatars/'.$forum->userForum->profile_image) }}" class="rounded-circle ms-3" width="80" height="76">
                                @endif	                          
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title">{{$forum->forumSubject}}</h4>
                                <p><b><i>Tags: {{$forum->forumCategory}}</i></b></p>
                                <p><i>by {{$forum->userForum->firstName}}</i></p>
                                <p class="card-text mb-4">
                                    <?php
                                        $string =  $forum->forumComment;
                                        if (strlen($string) >= 100) {
                                            $stringCut = substr($string, 0, 100);
                                            $endPoint = strrpos($stringCut, ' ');
                                            $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                                            $string .= '.......';
                                        }
                                        echo $string;
                                    ?>                                    
                                  
                                </p>
                            </div>											
                        </div>				
                        <a href="/forum/{{$forum->id}}/show" class="btn btn-outline mt-auto align-self-end">Read more</a>
                    </div>
                    
                    
                    <div class="card-footer forum-footer">
                        <div class="d-flex bd-highlight mb-3">
                            <div class="me-auto p-2 bd-highlight">
                                <i>{{ \Carbon\Carbon::parse($forum->dateTime)->format('F j , Y  h:i A')}}</i>
                            </div>
                            @if (auth()->user()->id == $forum->user_id)
                            <div class="p-2 bd-highlight">
                                <a href="/forum/{{$forum->id}}/edit">
                                    <i class="fa fa-edit green"></i>
                                </a>
                            </div>
                            <div class="p-2 bd-highlight">
                                <form method="POST" action="/forum/{{$forum->id}}">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="delete">
                                        <i class="fa fa-trash-o red"></i>
                                    </button>
                                </form>                   
                            </div>
                            @else 
                            <div class="p-2 bd-highlight">
                                <a href="/forum/{{$forum->id}}/warningForum" class="text-decoration-none text-black">
                                    <img src="{{asset('img/report.png')}}" width=20>
                                </a>
                            </div>  
                            @endif                           				
                        </div>
                    </div>
                </div>
            </div>    

        @empty 
            <h4 class="text-center mt-5">No results</h4>
        @endforelse


    </div>

</div>

<br><br><br><br><br><br><br><br>

@endsection