@if($paymentProof == null) 
    None
@else
    <a href="{{asset('storage/paymentProof/' . $paymentProof)}}" download>
        <button class="btn btn-other" onclick="return confirm('Download a payment?')">Download</button>
    </a>
@endif