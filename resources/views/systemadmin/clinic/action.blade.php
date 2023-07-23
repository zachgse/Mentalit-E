<form action="/systemadmin/clinic/{{$id}}" method="post">
@csrf
@method('PUT')
    @if ($clinicStatus == 1)
        <button class="btn btn-danger" type="submit" onclick="return confirm('Deactivate a clinic?')">Deactivate</button>
    @else
        <button class="btn btn-outline" type="submit" onclick="return confirm('Activate a clinic?')">Activate</button>
    @endif
</form>


