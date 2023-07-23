@extends('layouts.app')
@section('content')


<div class="container">
	<h1 class="text-center">Book now!</h1>
	<br><hr class="divider"><br>
    
	<div class="d-flex bd-highlight mb-3">
	
		<div class="me-auto p-2 bd-highlight"></div>

        <form action="/booking/search" method="post">
			@csrf
            <input type="search" name="query" class="form-control-md p-2" placeholder="Search...">
            <button class="btn btn-outline btn-search m-0" type="submit">
                    <i class="fa fa-search"></i>
            </button>
        </form>
	
	</div>

	<br>

	<div class="row m-auto">
		@forelse($clinics as $clinic)
		<div class="col-lg-3 mb-3 d-flex align-items-stretch">
			<div class="card p-2" style="width:100%;">
				<div class="card-header clinic-header">
					@if ($clinic->clinicMainPhoto == null)  
						<img src="{{ asset('storage/avatars/hospital.png')}}" class="rounded" width="250" height="250">		
					@else
						<img src="{{ asset('storage/avatars/'.$clinic->clinicMainPhoto) }}" class="rounded" width="250" height="250">
					@endif	
				</div>
				<div class="card-body d-flex flex-column">
					<h5 class="card-title">{{$clinic->clinicName}}</h5>
					Located at: {{$clinic->clinicAddress}}
					<p class="card-text mb-4 mt-2">
						<?php
							$string =  $clinic->clinicDescription;
							if (strlen($string) >= 50) {
								$stringCut = substr($string, 0, 50);
								$endPoint = strrpos($stringCut, ' ');
								$string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
								$string .= '.......';
							}
							echo $string;
						?>                                      
					</p>
				</div>

				<div class="card-footer clinic-footer">
					<a href="/booking/{{ $clinic->id }}/show" class="m-auto">
						<button type="submit" class="btn btn-outline">Book</button>
					</a> 
				</div>

			</div>
		</div>
		@empty
			<h3 class="text-center">No results</h3>
		@endforelse

	</div>

</div>	

<br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br>

@endsection