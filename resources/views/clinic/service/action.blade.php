@if(auth()->user()->userType == 'ClinicAdmin')
<div class="d-flex justify-content-center">
    <div class="p-2 bd-highlight">    
        <a href="/clinic/service/{{$id}}/edit">
            <button type="submit" class="btn btn-outline">Edit</button>
        </a>
    </div>
    <div class="p-2 bd-highlight">    
        <form action="/clinic/service/{{$id}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete the service?')">Delete</button>
        </form>
    </div>
</div>
@endif