@if($paymentStatus == "Pending")
<div class="d-flex justify-content-center">
    <div class="p-2 bd-highlight">    
        <form action="/systemadmin/payment/{{$id}}/accept" method="post">
        @csrf
        @method('PUT')
            <button class="btn btn-outline" type="submit" onclick="return confirm('Accept a payment?')">
                Accept
            </button>
        </form>
    </div>
    <div class="p-2 bd-highlight">    
        <form action="/systemadmin/payment/{{$id}}/decline" method="post">
        @csrf
        @method('PUT')      
            <button class="btn btn-danger" type="submit" onclick="return confirm('Decline a payment?')">
                Decline
            </button>
        </form>
    </div>
</div>
@else
    <form action="/systemadmin/payment/{{$id}}" method="post">
    @csrf
    @method('DELETE')        
        <button class="btn btn-danger" type="submit" onclick="return confirm('Delete a payment?')">
            Delete
        </button>
    </form>
@endif


 
 






 
 







 
 






 
 




