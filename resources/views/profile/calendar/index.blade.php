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
                
                <h2 class="text-center">Booking Calendar</h2>
                <br><hr class="divider"><br>
                <div id="calendar"></div>

   
            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection


@section('scripts')
<script>

$(document).ready(function () {

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    var calendar = $('#calendar').fullCalendar({
        editable:false,
        header:{
            left:'prev,next today',
            center: 'title',
            right:'month,agendaWeek,agendaDay'
        },
        events:'/profile/calendar/index',
 
        selectHelper: true,
        select:function(start, end, allDay)
        {
            var title = prompt('Event Title:');

            if(title)
            {
                var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
                var employee
                var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');
            }
        }, 
    });
});
</script> 

@endsection
				













