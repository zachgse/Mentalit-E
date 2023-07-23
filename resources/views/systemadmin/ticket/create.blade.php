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
                <a href="/systemadmin/ticket/index">
                    <i class="fa fa-angle-left"></i>
                </a>
            </div>

            <div class="p-2 bd-highlight">
                <h4 class="text-center">File a ticket</h4>
            </div>

            <div class="p-2 bd-highlight"></div>
        </div>    

        <br><hr class="divider"><br>

        <form method="POST" action="/systemadmin/ticket" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 w-75 auto">
                <label class="form-label text-center bold">Ticket Subject</label>
                <input type="text" class="form-control w-75 auto @error('ticketSubject') is-invalid @enderror" name="ticketSubject" value="{{ old('ticketSubject') }}" required autocomplete="ticketSubject">
                @error('ticketSubject')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror                  
            </div>    
            
            <div class="mb-3 w-75 auto">
                <label class="form-label text-center bold">Ticket Category</label>
                <select name="ticketCategory" type="text" class="form-control text-center w-75 auto @error('ticketCategory') is-invalid @enderror" required autocomplete="select ticket category">
                    <option value="none" selected disabled hidden>-- Select the ticket category --</option>                         
                    <option value="General Inquiry">General Inquiry</option>
                    <option value="Feedback">Feedback</option>
                    <option value="Problem">Problem</option> 
                    <option value="Others">Others</option>                                                                   
                </select>        
                @error('ticketCategory')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror         
            </div>
            
            <div class="mb-3 w-75 auto">
                <label class="form-label text-center bold">Ticket Description</label>
                <textarea class="form-control w-75 auto @error('ticketDescription') is-invalid @enderror" rows="4" name="ticketDescription" required autocomplete="ticketDescription" autofocus>{{ old('ticketDescription') }}</textarea> 
                @error('ticketDescription')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror         
            </div>    
            
            <div class="mb-3 w-75 auto">
                <label class="form-label text-center bold">Attachment (if applicable)</label>
                <input class="form-control w-75 auto @error('file') is-invalid @enderror" type="file" name="file" accept="image/*, application/pdf, application/msword, .doc, .docx" autofocus>	           
                @error('file')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror    
            </div>              

            <br><br>
           
            <button class="btn btn-outline" type="submit" onclick="return confirm('Submit the ticket?')">Submit</button>

        </form>
    </div>
</div>

@endsection



