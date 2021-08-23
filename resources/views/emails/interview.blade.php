@component('mail::message')
# Congratulation

Dear {{$name}},<br>
Welcome to Summer Internship 2021 Program at Fatima Al-Fihri Open University,
We are happy to let you know that your application to join our internship program got accepted for an interview!<br>
To book your interview please click this button:<br>
@component('mail::button', ['url' => $link])
Book your interview
@endcomponent
<br>
Note: The session for interviews will be only between Monday 23rd of August to Tuesday 31st, August 2021. Then all results will be announced the next day,<br>
The accepted interns will start immediately, by 1 September and will be part of our team for the next 3 months (until 30 November).<br>

Regards,<br>
Brahim Benzarti,<br>
IT Manager,<br>
{{ config('app.name') }}.
@endcomponent
