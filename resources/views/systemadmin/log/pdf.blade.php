<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('img/ProjectIcon.png')}}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link href="{{ asset('css/style.css') }}" rel="stylesheet"> <!-- External Css-->
	<script type="text/javascript" src="/js/script.js"></script> <!-- External JS -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Google captcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!--Full Calendar-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <!--Date time-->
    <script src="https://momentjs.com/downloads/moment.js"></script>

</head>
<body>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Email Address</th>
                <th>Type</th>
                <th>Description</th>
                <th>dateTime</th>
            </tr>
        </thead>
        <tbody>
        @foreach($logs as $log)
            <tr>
                <td>{{ $loop->iteration}}</td>
                <td>{{ $log->userLog->email}} </td>
                <td>{{ $log->type}} </td>
                <td>{{ $log->description}} </td>
                <td>{{ $log->dateTime}} </td>
            </tr>
        </tbody>
        @endforeach
    </table>
</body>
</html>




