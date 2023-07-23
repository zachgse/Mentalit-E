@extends('layouts.app')

@section('content')

<style>
    @media print {
       .navbar{
            visibility:hidden;
            display:none;
        }

        .col-lg-3 {
            visibility:hidden;
            display:none;
        }

        .footer-hide {
            visibility:hidden;
            display:none; 
        }
        
        .btn {
            visibility:hidden;
            display:none; 
        }
    }

</style>

<div class="container">
    <div class="row">

    @include('inc.clinic')		

        <div class="col-lg-9">

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif         

            <div class="shadow p-5 w-100 standard">

                <h2 class="text-center mb-5">Clinic Statistics</h2>

                <button type="button" class="btn btn-outline" onclick="window.print()">Print</button>
                
                <div class="row my-5">
                    <div class="col-lg-4">
                        <p><b>Remaining Day/s of Susbcription</b></p>
                        <h3 class="pink">{{$clinic->subscriptionDuration}}</h3>
                    </div>
                    <div class="col-lg-4">
                        <p><b>Clinic Rating/s</b></p>
                        <h3 class="pink">
                        @if ($average == null)
                            0
                        @else
                            @for($i=1; $i<=$average; $i++) 
                                <span><i class="fa fa-star" id="twinkle" style="font-size: 30px;"></i></span>
                            @endfor 
                        @endif
  
                        </h3>
                    </div>
                    <div class="col-lg-4">
                        <p><b>Number of Service/s</b></p>
                        <h3 class="pink">{{$service->count()}}</h3>
                    </div>
                </div>

                <div id="pie-chart-booking_status" class="auto" style="width: 750px; height: 500px"></div>

                <div id="pie-chart-employeestatus" class="auto" style="width: 750px; height: 500px"></div> 

            </div>

        </div>

    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection

@section('scripts')
<!-- CHART SCRIPTS -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});

    google.charts.setOnLoadCallback(bookingStatusChart); //Call Chart for Booking Status
    google.charts.setOnLoadCallback(employeeStatusChart); //Call Chart for Booking Status

    function bookingStatusChart() {
        var data3 = google.visualization.arrayToDataTable([
            ['Clinic Bookings', 'Number of Bookings'],

            <?php
                foreach($booking_status as $d3) {
                echo "['".$d3->status."', ".$d3->count3."],";
                }
            ?>

        ]);

        var options = {
            title: 'Bookings',
            is3D: false,
            colors: ['#34BE82', '#3da5d9', '#FFAEBC', '#FCB5AC', '#DBA40E'],
        };

        var chart = new google.visualization.PieChart(document.getElementById('pie-chart-booking_status'));

        chart.draw(data3, options);
    }

    function employeeStatusChart() {
        var data5 = google.visualization.arrayToDataTable([
            ['Status', 'Number of Employees'],

            <?php
                
                foreach($employeeCount as $d5) {
                    echo "['Status: ".$d5->accountStatus."', ".$d5->count4."],";
                }

            ?>

        ]);

        var options = {   
            title:'Total of Employees',                     
            is3D: false,
            colors: ['#34BE82', '#3da5d9', '#FFAEBC'],
        };

        var chart = new google.visualization.PieChart(document.getElementById('pie-chart-employeestatus'));
        chart.draw(data5, options);
    }  

</script>
@endsection
				




