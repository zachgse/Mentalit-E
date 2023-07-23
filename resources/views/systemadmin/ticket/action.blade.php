<div class="d-flex justify-content-center">
    <div class="p-2 bd-highlight">    
        <a href="/systemadmin/ticket/{{$id}}/view">
            <button type="submit" class="btn btn-outline">View</button>
        </a>
    </div>
    @if($ticketStatus == "Pending")
    <div class="p-2 bd-highlight">    
        <form action="/systemadmin/ticket/{{$id}}/update" method="post">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Close the ticket?')">Close</button>
        </form>  
    </div>
    @elseif($ticketStatus == "Closed")
    <div class="p-2 bd-highlight">    
        <form action="/systemadmin/ticket/{{$id}}/archive" method="post">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Archive the ticket?')">Archive</button>
        </form>  
    </div>
    @endif
</div>