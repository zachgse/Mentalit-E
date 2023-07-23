@if($status == 1 && $email_verified_at != null) 
    Active
@elseif($status == 1 && $email_verified_at == null) 
    Email not yet verified
@elseif($status == 0 && $email_verified_at != null) 
    Inactive
@elseif($status == 0 && $email_verified_at == null) 
    Email not yet verified
@endif