@if($accountStatus == "Pending")
<div class="d-flex justify-content-center">
    <form action="/clinic/employee/{{$id}}/accept" method="post">
    @csrf
    @method('PUT')
        <button class="btn btn-outline" type="submit" onclick="return confirm('Accept the Employee?')">
            Accept
        </button>
    </form>

    <form action="/clinic/employee/{{$id}}/decline" method="post">
    @csrf
    @method('DELETE')        
        <button class="btn btn-danger" type="submit" onclick="return confirm('Decline the Employee?')">
            Decline
        </button>
    </form>
</div>
@elseif ($accountStatus == "Active" || $accountStatus == "Inactive")
    @if ($accountStatus == "Active")
    <form action="/clinic/employee/{{$id}}/update" method="post">
    @csrf
    @method('PUT')
        <button class="btn btn-danger" type="submit" onclick="return confirm('Deactivate the Employee?')">
            Deactivate
        </button>
    </form>
    @else
    <form action="/clinic/employee/{{$id}}/update" method="post">
    @csrf
    @method('PUT')
        <button class="btn btn-outline" type="submit" onclick="return confirm('Activate the Employee?')">
            Activate
        </button>
    </form>
    @endif
@endif


 
 






 
 







 
 






 
 




