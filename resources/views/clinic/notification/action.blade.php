

<form action="/clinic/notification/{{$id}}" method="post">
    @csrf
    @method('DELETE')        
    <button class="btn btn-danger" type="submit" onclick="return confirm('Delete the item?')">
        Delete
    </button>
</form>



 
 






 
 







 
 






 
 




