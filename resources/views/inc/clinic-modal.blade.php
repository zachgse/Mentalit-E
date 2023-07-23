<!-- Modal for payment]  -->
<div class="modal fade" id="payment" aria-hidden="true">
    <div class="modal-dialog modal-md">
    <div class="modal-content p-1">
        <h4 class="text-center mt-3">Payment instructions</h4>
        <br><hr class="divider"><br>
            @if($clinic->clinicPaymentInfo == null)
                <p class="text-center">No payment info yet. Contact the clinic for more info. 
                    <br><b>Clinic Phone Number:</b> {{$clinic->clinicNumber}}
                </p>
            @else
                <p class="text-left">
                    {{$clinic->clinicPaymentInfo}}
                </p>
            @endif               
    </div>
    </div>
</div>