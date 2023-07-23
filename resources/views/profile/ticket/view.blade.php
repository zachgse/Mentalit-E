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
                        <a href="/profile/ticket/index">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>

                    <div class="p-2 bd-highlight">
                        <h4>View a ticket</h4>
                    </div>

                    <div class="p-2 bd-highlight"></div>
                </div>


                <br><hr class="divider"><br>

                <div class="d-flex bd-highlight mb-3">
                    <div class="me-auto p-2 bd-highlight">
                        <b>Name: </b>{{$var->userTicket->firstName}} {{$var->userTicket->MiddleName}} {{$var->userTicket->lastName}}
                    </div>
                    <div class="p-2 bd-highlight"></div>
                    <div class="p-2 bd-highlight">
                        <b>Date Issued: </b>{{ \Carbon\Carbon::parse($var->dateTimeIssued)->format('F j , Y  h:i A')}}
                        <br>
                        <p style="margin-right: 110px;">
                        <b>Ticket Status: </b>{{$var->ticketStatus}}
                        </p>
                    </div>
                </div>

                <br><hr><br>

                <h4 class="text-left ms-2">Ticket Subject: {{$var->ticketSubject}}</h4>
                <i class="pull-left ms-4">Ticket Category: {{$var->ticketCategory}}</i>
                <br><br>  
                <p class="text-left ms-5">{{$var->ticketDescription}}</p>
                @if ($var->file != null) 
                    <a href="{{asset('storage/ticket/'.$var->file)}}" download>
                        <button class="btn btn-other" onclick="return confirm('Download the attached file?')">Download attached file</button>
                    </a>                
                @endif		

                <br><br><hr>        
                
                @if($var->ticketStatus != "Closed" && $var->ticketStatus != "Archived")
                    <br>
                    <h4>Add your feedback</h4>
                    <br>
                    <form method="POST" action="/profile/ticket/{{$var->id}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <textarea class="form-control @error('ticketCommentContent') is-invalid @enderror" rows="4" name="ticketCommentContent" required></textarea>
                    @error('ticketCommentContent')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror   

                    <div class="mt-5 w-50 auto">
                        <label class="form-label text-center bold">Attachment (if applicable)</label>
                        <input class="form-control w-75 auto" type="file" name="file" accept="image/*, application/pdf, application/msword, .doc, .docx">	       
                    @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror      
                    </div>  
            
                    <div class="d-flex bd-highlight">
                
                        <div class="me-auto p-2 bd-highlight"></div>
            
                        <div class="p-2 bd-highlight">		
                            <button type="submit" class="btn btn-outline ms-auto mt-2" onclick="return confirm('Submit the response?')">Submit</button>
                        </div>
                    </div>
                    </form>
                    <br><hr> 
                @endif

                <br>
                    <h4>Feedback history</h4>
                    <br>
                    @forelse ($comments as $comment)
                        @if($comment->user_id == $user->id)
                        <div class="d-flex justify-content-start">
                            <div class="p-2 me-auto bd-highlight">
                                <i>{{ \Carbon\Carbon::parse($comment->ticketCommentDateTime)->format('F j , Y  h:i A')}}</i>
                            </div>	
                            <div class="p-2 bd-highlight text-right">			
                                <h5>{{$comment->userTicketComment->firstName}} {{$comment->userTicketComment->middleName}} {{$comment->userTicketComment->lastName}}</h5> 
                                <i>({{$comment->userTicketComment->userType}})</i>
                                <p class="mt-3">
                                    {{$comment->ticketCommentContent}}
                                    <br><br>
                                    @if ($comment->file != null) 
                                        <a href="{{asset('storage/ticket/'.$comment->file)}}" download>
                                            <button class="btn btn-other" onclick="return confirm('Download the attached file?')">Download attached file</button>
                                        </a>                
                                    @endif	                                    			
                                </p>
                            </div>
                            <div class="p-2 bd-highlight">
                                @if ($comment->userTicketComment->profile_image == null)  
                                    <img src="{{asset('img/user.png')}}" class="rounded-circle ms-3" width="80" height="76">	
                                @else
                                    <img src="{{ asset('storage/avatars/'.$comment->userTicketComment->profile_image) }}"class="rounded-circle ms-3" width="80" height="76">
                                @endif	                 
                            </div>
                        </div>
                        <br><hr>	
                        @else
                        <div class="d-flex justify-content-start">
                            <div class="p-2 bd-highlight">
                                @if ($comment->userTicketComment->profile_image == null)  
                                    <img src="{{asset('img/user.png')}}" class="rounded-circle ms-3" width="80" height="76">	
                                @else
                                    <img src="{{ asset('storage/avatars/'.$comment->userTicketComment->profile_image) }}" class="rounded-circle ms-3" width="80" height="76">
                                @endif	                 
                            </div>
                            <div class="p-2 me-auto bd-highlight text-left">			
                                <h5>{{$comment->userTicketComment->firstName}} {{$comment->userTicketComment->middleName}} {{$comment->userTicketComment->lastName}}</h5> 
                                <i>({{$comment->userTicketComment->userType}})</i>
                                <p class="mt-3">
                                    {{$comment->ticketCommentContent}}
                                    <br><br>
                                    @if ($comment->file != null) 
                                        <a href="{{asset('storage/ticket/'.$comment->file)}}" download>
                                            <button class="btn btn-other" onclick="return confirm('Download the attached file?')">Download attached file</button>
                                        </a>                
                                    @endif		
                                </p>
                            </div>		
                            <div class="p-2 bd-highlight">
                                <i>{{ \Carbon\Carbon::parse($comment->ticketCommentDateTime)->format('F j , Y  h:i A')}}</i>
                            </div>				
                        </div>
                        <br><hr>	
                        @endif	
                    @empty
                    <div class="row border p-5 shadow-sm mb-3">
                        <p class="text-center">No Feedback yet</p>
                    </div>
                    @endforelse

            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection








