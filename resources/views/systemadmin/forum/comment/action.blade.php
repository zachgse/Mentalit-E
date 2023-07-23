<form method="POST" action="/systemadmin/commentForum/{{$id}}">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger"type="submit" onclick="return confirm('Delete a comment?')">Delete</button>
</form>