<div class="dropdown">
    <button class="btn btn-outline" type="button"id="action-{{ $id }}" data-bs-toggle="dropdown" aria-expanded="false">
        ...
    </button>

    <ul class="dropdown-menu text-center" aria-labelledby="action-{{ $id }}">
        <li class="none">
            <form method="POST" action="/systemadmin/user/{{$id}}">
                @csrf
                @method('PUT')
                @if($status == 1)
                    <button class="btn btn-none"type="submit" onclick="return confirm('Deactivate a user?')">Deactivate</button>
                @else
                    <button class="btn btn-none"type="submit" onclick="return confirm('Activate a user?')">Activate</button>
                @endif
            </form>
        </li>        
        <li>
            <a class="dropdown-item" href="/systemadmin/user/{{$id}}/notification">
                Notify
            </a>
        </li>
        <li>
        <a class="dropdown-item" href="/systemadmin/user/{{$id}}/warning">
                Warning
            </a>
        </li>
        <li>
        <a class="dropdown-item" href="/systemadmin/user/{{$id}}/award">
                Award
            </a>
        </li>
    </ul>
</div>
 
 





 
 




