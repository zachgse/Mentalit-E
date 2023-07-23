<div class="dropdown">
    <button class="btn btn-outline" type="button"id="action-{{ $id }}" data-bs-toggle="dropdown" aria-expanded="false">
        ...
    </button>

    <ul class="dropdown-menu text-center" aria-labelledby="action-{{ $id }}">
        @if($status == "To Pay")
        <li>
            <a class="dropdown-item" href="/booking/patient/{{$id}}/view">
                View
            </a>
        </li> 
        <li>
            <a class="dropdown-item" href="/booking/patient/{{$id}}/cancel">
                Cancel
            </a>
        </li>
        @elseif($status == "In Progress")
        <li>
            <a class="dropdown-item" href="/booking/patient/{{$id}}/view">
                View
            </a>
        </li> 
        @elseif($status == "To Rate")
        <li>
            <a class="dropdown-item" href="/booking/patient/{{$id}}/view">
                View
            </a>
        </li> 
        <li>
            <a class="dropdown-item" href="/booking/patient/{{$id}}/ratings">
                Rate
            </a>
        </li>   
        @elseif($status == "Done")
        <li>
            <a class="dropdown-item" href="/booking/patient/{{$id}}/view">
                View
            </a>
        </li> 
        @elseif($status == "To Cancel")
        <li>
            <a class="dropdown-item" href="/booking/patient/{{$id}}/view">
                View
            </a>
        </li>      
        @endif
    </ul>
</div>

