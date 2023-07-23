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

    @include('inc.profile')		

        <div class="col-lg-9">

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif         

        <main>
            <div class="shadow p-5 w-100 standard">

                <h2 class="text-center mb-5">System Statistics</h2>
                
                <button type="button" class="btn btn-outline" onclick="window.print()">Print</button>
                
                <div class="row my-5">
                    <div class="col-lg-4">
                        <p><b>Total of Community Forum Posts</b></p>
                        <h3 class="pink">{{$forum->count()}}</h3>
                    </div>
                    <div class="col-lg-4">
                        <p><b>Total of Bookings</b></p>
                        <h3 class="pink">{{$booking->count()}}</h3>
                    </div>
                    <div class="col-lg-4">
                    <p><b>Total of Awards given</b></p>
                        <h3 class="pink">{{$award->count()}}</h3>
                    </div>
                </div>

                <div id="bar-chart-user" class="auto" style="width: 750px; height: 500px"></div> 

                <div id="pie-chart-clinicstatus" class="auto" style="width: 750px; height: 500px"></div> 

                <div id="pie-chart-ticketstatus" class="auto" style="width: 750px; height: 500px"></div> 
                
            </div>
        </main>
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

    google.charts.setOnLoadCallback(userChart); //Call Chart for Users
    google.charts.setOnLoadCallback(clinicStatusChart); //Call Chart for Clinic Status
    google.charts.setOnLoadCallback(ticketStatusChart); //Call Chart for Ticket Status


    function userChart() {

        var data2 = google.visualization.arrayToDataTable([
        ['Month Name', 'Registered Users'],

        <?php
        foreach($ucount as $d) {
            echo "['".$d->month_name."', ".$d->count."],";
            }
        ?>
        ]);

        var barchart_options = {
            title:'Registered Users per Month',
            legend: 'none',
            colors: ['#34BE82'],
        };

        var barchart = new google.visualization.ColumnChart(document.getElementById('bar-chart-user'));

        barchart.draw(data2, barchart_options);
    }

    function clinicStatusChart() {
        var data4 = google.visualization.arrayToDataTable([
            ['Status', 'Number of Clinics'],

            <?php
                
                foreach($cstatuscount as $d4) {
                    if ($d4->clinicStatus == 0) {
                        $d4->clinicStatus = "Inactive";
                    } 
                    else {
                        $d4->clinicStatus = "Active";
                    }
                    echo "['Status: ".$d4->clinicStatus."', ".$d4->count4."],";
                }
                

            ?>

        ]);

        var options = {   
            title:'Total of Clinics',                     
            is3D: false,
            colors: ['#34BE82', '#3da5d9'],
        };

        var chart = new google.visualization.PieChart(document.getElementById('pie-chart-clinicstatus'));
        chart.draw(data4, options);
    }

    function ticketStatusChart() {
        var data5 = google.visualization.arrayToDataTable([
            ['Status', 'Number of Tickets'],

            <?php
                
                foreach($tstatuscount as $d5) {
                    echo "['Status: ".$d5->ticketStatus."', ".$d5->count5."],";
                }
                

            ?>

        ]);

        var options = {   
            title:'Total of Tickets',                     
            is3D: false,
            colors: ['#34BE82', '#3da5d9', '#FFAEBC', '#FCB5AC'],
        };

        var chart = new google.visualization.PieChart(document.getElementById('pie-chart-ticketstatus'));
        chart.draw(data5, options);
    }                    
</script>
@endsection
				




