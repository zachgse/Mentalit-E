@if($status == 'To Pay' || $status == 'In Progress')
    @if($link == null)
        No Link yet
    @else 
    <a href="{{$link}}">
        <button class="btn btn-other pull-left">Click Link</button>
    </a>
    @endif

@elseif ($status == 'To Cancel')
    Cancellation file in progress
@else
    Booking is done
@endif

