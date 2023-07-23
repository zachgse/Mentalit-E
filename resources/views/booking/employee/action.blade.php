<div class="dropdown">
    <button class="btn btn-outline" type="button"id="action-{{ $id }}" data-bs-toggle="dropdown" aria-expanded="false">
        ...
    </button>

    <ul class="dropdown-menu text-center" aria-labelledby="action-{{ $id }}">
        @if($status == "In Progress")
        <li>
            <a class="dropdown-item" href="/booking/employee/{{$id}}/display">
                View
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="/record/{{$id}}/show">
                Patient Records
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="/booking/employee/{{$id}}/remarks">
                Mark as done
            </a>
        </li>
        @endif
    </ul>
</div>

