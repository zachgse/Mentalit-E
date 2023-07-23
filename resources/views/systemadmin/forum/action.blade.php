<div class="dropdown">
    <button class="btn btn-outline" type="button"id="action-{{ $id }}" data-bs-toggle="dropdown" aria-expanded="false">
        ...
    </button>

    <ul class="dropdown-menu text-center" aria-labelledby="action-{{ $id }}">
        <li>
            <a class="dropdown-item" href="/systemadmin/forum/{{$id}}/comment/index">
                View Comments
            </a>
        </li>        
        <li class="none">
            <form method="POST" action="/systemadmin/forum/{{$id}}">
                @csrf
                @method('DELETE')
                <button class="btn bnt-none"type="submit" onclick="return confirm('Delete a post?')">Delete</button>
            </form>
        </li>        
    </ul>
</div>
 
 





 
 




