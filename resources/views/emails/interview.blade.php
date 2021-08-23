@component('mail::message')
# Congratulation

Dear {{$Applicant_Name ?? "Applicant Name"}},<br>
Welcome to Summer Internship 2021 Program at Fatima Al-Fihri Open University,
We are happy to let you know that your application to join our internship program gets accepted for an interview!<br>
To book your interview please click this button:<br>
@component('mail::button', ['url' => $Meeting_Link ?? "www.link.com", 'color'=> 'blue'])
Book your interview
@endcomponent
<br>
Note: The session for interviews will be only between Monday 23rd August to Tuesday 31st August 2021. Then all results will be announced in the next 5 days.<br>
The accepted interns will start immediately, by 15 September, and will be part of our team for the next 3 months (until 14 December).<br>

Best regards.<br>
@component('mail::table', ['name'=>$User_Name ?? "FAOU Admin", 'position'=>$User_Position ?? "Concil Member", 'phone'=>$User_Phone ?? "212633295241"])

@endcomponent
@endcomponent
