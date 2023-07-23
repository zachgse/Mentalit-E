@extends('layouts.app')
@section('content')

<div class="container">
    <div class="shadow-lg p-3 mb-5 rounded w-50 m-auto">
        <h4 class="text-center">Apply to a clinic</h4>
        <br><hr class="divider"><br>
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <form method="POST" action="/apply" enctype="multipart/form-data">
            @csrf

            <div>
                <label>Clinic list</label>
                <select name="clinic_id" id="" class="form-control input-sm w-50 m-auto text-center mt-3">
                @foreach ($clinics as $clinic)
                    <option value="none" selected disabled hidden>-- Select the clinic --</option> 
                    <option value="{{$clinic->id}}">{{$clinic->clinicName}}</option>
                @endforeach
                </select>
            </div>

            <br>

            <div class="mb-3 w-75 auto">
                <label class="form-label">PRC License</label>
                <input class="form-control w-75 auto" type="file" name="prcLicense">							
            </div>   

            <br>            

            <button class="btn btn-outline" type="submit" onclick="return confirm('Send an application to this clinic?')">Apply to a clinic</button>
        </form>
        <br>
    </div>
</div>

@endsection
