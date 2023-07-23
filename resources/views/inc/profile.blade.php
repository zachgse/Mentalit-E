@if(Auth::user()->userType == 'SystemAdmin')
<div class="col-lg-3">
    <div class="shadow text-left pointer p-3">
        <div class="d-flex justify-content-start">
            <div class="me-3 bd-highlight">
                @if ($user->profile_image == null)  
                    <img src="{{ asset('storage/avatars/default.png')}}" class="rounded-circle" width="80" height="76">		
                @else
                    <img src="{{ asset('storage/avatars/'.$user->profile_image) }}" class="rounded-circle" width="80" height="76">
                @endif	
            </div>
            <div class="bd-highlight mt-3">			
                <h4 class="text-left"><b>{{ Auth::user()->firstName }}</b></h4>
            </div>						
        </div>	
        <hr>   
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/systemadmin/dashboard/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/dashboard.png')}}" class="me-2" width=20> System Dashboard
                </a>
            </div>				
        </div>
        <hr>             
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/profile/profile/edit" class="text-decoration-none text-black">
                    <img src="{{asset('img/edit.png')}}" class="me-2" width=20> Edit personal info
                </a>
            </div>				
        </div>
        <hr>					
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/systemadmin/log/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/task.png')}}" class="me-2" width=20> Audit logs
                </a>
            </div>				
        </div>
        <hr>				
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/systemadmin/user/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/user.png')}}" class="me-2" width=20> Manage Users
                </a>
            </div>				
        </div>
        <hr>
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/systemadmin/payment/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/payment.png')}}" class="me-2" width=20> Manage Payment
                </a>
            </div>				
        </div>
        <hr>													
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/systemadmin/clinic/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/hospital.png')}}" class="me-2" width=20> Manage Clinics
                </a>
            </div>				
        </div>
        <hr>
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/systemadmin/forum/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/reply.png')}}" class="me-2" width=20> Manage Community Forum
                </a>
            </div>				
        </div>
        <hr>	
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/systemadmin/warning/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/exclamation.png')}}" class="me-2" width=20> Manage Warning
                </a>
            </div>				
        </div>
        <hr>			
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/systemadmin/ticket/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/ticket.png')}}" class="me-2" width=20> Manage Ticket
                </a>
            </div>				
        </div> 						       
	   
    </div>
</div>
@elseif(Auth::user()->userType == 'ClinicAdmin' || Auth::user()->userType == 'ClinicEmployee')
<div class="col-lg-3">
    <div class="shadow text-left pointer p-3">
        <div class="d-flex justify-content-start">
            <div class="me-3 bd-highlight">
                @if ($user->profile_image == null)  
                    <img src="{{ asset('storage/avatars/default.png')}}" class="rounded-circle" width="80" height="76">		
                @else
                    <img src="{{ asset('storage/avatars/'.$user->profile_image) }}" class="rounded-circle" width="80" height="76">
                @endif	
            </div>
            <div class="bd-highlight mt-3">			
                <h4 class="text-left"><b>{{ Auth::user()->firstName }}</b></h4>
            </div>						
        </div>	
        <hr>        
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/profile/profile/edit" class="text-decoration-none text-black">
                    <img src="{{asset('img/dashboard.png')}}" class="me-2" width=20> Edit personal info
                </a>
            </div>				
        </div>
        <hr>					
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/booking/employee/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/consultation.png')}}" class="me-2" width=20> View Booking
                </a>
            </div>				
        </div>
        <hr>			
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/calendar/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/calendar.png')}}" class="me-2" width=20> Calendar
                </a>
            </div>				
        </div>
        <hr>													
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/profile/notification/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/notification.png')}}" class="me-2" width=20> Notification
                </a>
            </div>				
        </div>
        <hr>				
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/profile/ticket/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/ticket.png')}}" class="me-2" width=20> Ticket
                </a>
            </div>				
        </div>
        
    </div>
</div>

@elseif(Auth::user()->userType == 'Patient')
<div class="col-lg-3">
    <div class="shadow text-left pointer p-3">
        <div class="d-flex justify-content-start">
            <div class="me-3 bd-highlight">
                @if ($user->profile_image == null)  
                    <img src="{{ asset('storage/avatars/default.png')}}" class="rounded-circle" width="80" height="76">		
                @else
                    <img src="{{ asset('storage/avatars/'.$user->profile_image) }}" class="rounded-circle" width="80" height="76">
                @endif	
            </div>
            <div class="bd-highlight mt-3">			
                <h4 class="text-left"><b>{{ Auth::user()->firstName }}</b></h4>
            </div>						
        </div>	
        <hr>        
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/profile/profile/edit" class="text-decoration-none text-black">
                    <img src="{{asset('img/dashboard.png')}}" class="me-2" width=20> Edit personal info
                </a>
            </div>				
        </div>
        <hr>					
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/booking/patient/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/consultation.png')}}" class="me-2" width=20> View Booking
                </a>
            </div>				
        </div>
        <hr>
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/profile/calendar/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/calendar.png')}}" class="me-2" width=20> Calendar
                </a>
            </div>				
        </div>
        <hr>	        				
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/profile/record/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/record.png')}}" class="me-2" width=20> Medical Record
                </a>
            </div>				
        </div>
        <hr>				
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/profile/journal/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/notebook.png')}}" class="me-2" width=20> Journal
                </a>
            </div>				
        </div>
        <hr>										
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/profile/notification/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/notification.png')}}" class="me-2" width=20> Notification
                </a>
            </div>				
        </div>
        <hr>				
        <div class="d-flex bd-highlight ms-3">
            <div class="bd-highlight">
                <a href="/profile/ticket/index" class="text-decoration-none text-black">
                    <img src="{{asset('img/ticket.png')}}" class="me-2" width=20> Ticket
                </a>
            </div>				
        </div>
        
    </div>
</div>
@endif