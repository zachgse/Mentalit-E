@if ($prcLicense == null)
    None
@else
<a href="{{asset('storage/prcLicense/' . $prcLicense)}}" download>
    <button class="btn btn-other" onclick="return confirm('Download the item?')">Download</button>
</a>
@endif