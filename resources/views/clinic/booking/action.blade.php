<div class="dropdown">
    <button class="btn btn-outline" type="button"id="action-{{ $id }}" data-bs-toggle="dropdown" aria-expanded="false">
        ...
    </button>

    @if (Auth::user()->userType == 'ClinicAdmin')
    <ul class="dropdown-menu text-center" aria-labelledby="action-{{ $id }}">
        @if($status == "To Pay")
        <li>
            <a class="dropdown-item" href="/clinic/booking/{{$id}}/view">
                Assign
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="/clinic/booking/{{$id}}/cancel">
                Decline
            </a>
        </li>
        @elseif($status == "To Cancel")
        <li>
            <a class="dropdown-item" href="/clinic/booking/{{$id}}/display">
                View
            </a>
        </li>        
        <li class="none">
            <form method="POST" action="/clinic/booking/{{$id}}">
                @csrf
                @method('DELETE')
                <button class="btn bnt-none"type="submit" onclick="return confirm('Approve cancellation?')">Approve</button>
            </form>
        </li>
        <li>
            <a class="dropdown-item" href="/clinic/booking/{{$id}}/view">
                Assign
            </a>
        </li>
        @else
        <li>
            <a class="dropdown-item" href="/clinic/booking/{{$id}}/display">
                View
            </a>
        </li>
        @endif
    </ul>
    @elseif (Auth::user()->userType == 'ClinicEmployee')
    <ul class="dropdown-menu text-center" aria-labelledby="action-{{ $id }}">
        <li>
            <a class="dropdown-item" href="/clinic/booking/{{$id}}/display">
                View
            </a>
        </li>
    </ul>
    @endif
</div>
 
 





 
 




