<div class="dropdown">
    <button class="btn btn-outline" type="button"id="action-{{ $id }}" data-bs-toggle="dropdown" aria-expanded="false">
        ...
    </button>

    <ul class="dropdown-menu text-center" aria-labelledby="action-{{ $id }}">
        <li>
            <a class="dropdown-item" href="/profile/journal/{{$id}}/view">
                View
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="/profile/journal/{{$id}}/edit">
                Edit
            </a>
        </li>
        <li class="none">
            <form method="POST" action="/profile/journal/{{$id}}">
                @csrf
                @method('DELETE')
                <button class="btn bnt-none"type="submit" onclick="return confirm('Delete a journal?')">Delete</button>
            </form>
        </li>
    </ul>
</div>
 
 





 
 




