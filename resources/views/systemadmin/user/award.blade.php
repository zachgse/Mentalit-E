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
                <a href="/systemadmin/user/index">
                    <i class="fa fa-angle-left"></i>
                </a>
            </div>

            <div class="p-2 bd-highlight">
                <h4 class="text-center">Award a user</h4>
            </div>

            <div class="p-2 bd-highlight"></div>
        </div>    

        <br><hr class="divider"><br>

        <form method="POST" action="/systemadmin/user/{{$var->id}}/storeaward">
            @csrf

            <div class="mb-3 w-75 auto">
                <label class="form-label text-center bold">Awards</label>
                <select name="award_id" type="text" class="form-control text-center  @error('award_id') is-invalid @enderror" required autocomplete="select award category">
                    <option value="none" selected disabled hidden>-- Select type of award --</option>  
                    @foreach($awards as $award)                           
                        <option value="{{$award->id}}">
                            {{$award->awardName}}
                        </option>
                    @endforeach
                </select>   
                @error('award_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror        
            </div>   

            <div class="mb-3 w-75 auto">
                <label class="form-label text-center bold">Message</label>
                <textarea class="form-control @error('notifDescription') is-invalid @enderror" rows="6" name="notifDescription" required autocomplete="notifDescription" autofocus></textarea>   
                @error('notifDescription')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror                  
            </div>    
                       
            <br><br>
           
            <button class="btn btn-outline" type="submit" onclick="return confirm('Send an award to the user?')">Submit</button>

        </form>
    </div>
</div>

@endsection



