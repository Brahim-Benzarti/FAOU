@component('mail::message')
# Better luck next time!

Dear **{{$Applicant_Name ?? "Applicant Name"}}**,

{{$body}}

@isset($footer)
@component('mail::subcopy')
{{$footer}}
@endcomponent
@endisset

Best regards.
@component('mail::table', ['name'=>$User_Name ?? "FAOU Admin", 'position'=>$User_Position ?? "Concil Member", 'phone'=>$User_Phone ?? "212633295241"])
@endcomponent
@endcomponent
