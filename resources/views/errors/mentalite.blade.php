@extends('layouts.app')

@section('title', '- File not found!')
@section('content')
    <div class="container">
        <br><br><br><br><br><br><br>
        <h1 class="text-center w-50 m-auto">@yield('message')</h1>
        <br>
        <p><i>If you think this is a mistake, contact the system administrator!</i></p>
    </div>
@endsection