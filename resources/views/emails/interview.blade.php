@component('mail::message')
# Congratulation

Dear **{{$Applicant_Name ?? "Applicant Name"}}**,

{{$body}}

@component('mail::button', ['url' => $Meeting_Link ?? "www.link.com", 'color'=> 'blue'])
Book your interview
@endcomponent

@isset($footer)
@component('mail::subcopy')
{{$footer}}
@endcomponent
@endisset

Best regards.
@component('mail::table', ['name'=>$User_Name ?? "FAOU Admin", 'position'=>$User_Position ?? "Concil Member", 'phone'=>$User_Phone ?? "212633295241"])
@endcomponent
@endcomponent
