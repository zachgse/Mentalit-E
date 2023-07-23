@if (Auth::user()->userType == 'ClinicAdmin')
<div class="col-lg-3">
    <div class="shadow text-left pointer p-3">
        <div class="d-flex justify-content-start">
            <div class="me-3 bd-highlight">
                @if ($clinic->clinicMainPhoto == null)  
                    <img src="{{ asset('storage/avatars/hospital.png')}}" class="rounded-circle" width="80" height="76">		
                @else
                    <img src="{{ asset('storage/avatars/'.$clinic->clinicMainPhoto) }}" class="rounded-circle" width="80" height="76">
                @endif	
            </div>
            <div class="bd-highlight mt-3">			
                <h4 class="text-left"><b>{{$clinic->clinicName}}</b></h4>
            </div>						
        </div>	
        <hr>
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/clinic/single" class="text-decoration-none text-black">
                    <img src="{{ asset('storage/avatars/hospital.png')}}" class="me-2" width=20> Clinic Information
                </a>
            </div>				
        </div>
        <hr>                
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/dashboard/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/dashboard.png')}}" class="me-2" width=20> Clinic Dashboard
                </a>
            </div>				
        </div>
        <hr>					
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/clinic/edit" class="text-decoration-none text-black">
                    <img src="{{asset('img/setting.png')}}" class="me-2" width=20> Edit Clinic Information
                </a>
            </div>				
        </div>
        <hr>
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/service/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/service.png')}}" class="me-2" width=20> Clinic Services
                </a>
            </div>				
        </div>
        <hr>                
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/booking/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/consultation.png')}}" class="me-2" width=20> Clinic Bookings
                </a>
            </div>				
        </div>
        <hr>				
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/record/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/record.png')}}" class="me-2" width=20> Patient Records
                </a>
            </div>				
        </div>
        <hr>				
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/employee/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/manage-employee.png')}}" class="me-2" width=20> Clinic Employees
                </a>
            </div>				
        </div>
        <hr>							
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/calendar" class="text-decoration-none text-black">
                    <img src="{{asset('img/calendar.png')}}" class="me-2" width=20> Clinic Calendar
                </a>
            </div>				
        </div>
        <hr>				
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/notification/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/notification.png')}}" class="me-2" width=20> Clinic Notification
                </a>
            </div>				
        </div>
        
    </div>
</div>	
@elseif (Auth::user()->userType == 'ClinicEmployee')
<div class="col-lg-3">
    <div class="shadow text-left pointer p-3">
        <div class="d-flex justify-content-start">
            <div class="me-3 bd-highlight">
                @if ($clinic->clinicMainPhoto == null)  
                    <img src="{{ asset('storage/avatars/hospital.png')}}" class="rounded-circle" width="80" height="76">		
                @else
                    <img src="{{ asset('storage/avatars/'.$clinic->clinicMainPhoto) }}" class="rounded-circle" width="80" height="76">
                @endif	
            </div>
            <div class="bd-highlight mt-3">			
                <h4 class="text-left"><b>{{$clinic->clinicName}}</b></h4>
            </div>						
        </div>	
        <hr>
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/clinic/single" class="text-decoration-none text-black">
                    <img src="{{ asset('storage/avatars/hospital.png')}}" class="me-2" width=20> Clinic Information
                </a>
            </div>				
        </div>
        <hr>                
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/service/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/service.png')}}" class="me-2" width=20> Clinic Services
                </a>
            </div>				
        </div>
        <hr>                
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/booking/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/consultation.png')}}" class="me-2" width=20> Clinic Bookings
                </a>
            </div>				
        </div>
        <hr>				
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/record/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/record.png')}}" class="me-2" width=20> Patient Records
                </a>
            </div>				
        </div>
        <hr>							
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/clinic/calendar" class="text-decoration-none text-black">
                    <img src="{{asset('img/calendar.png')}}" class="me-2" width=20> Clinic Calendar
                </a>
            </div>				
        </div>
        
    </div>
</div>
@endif