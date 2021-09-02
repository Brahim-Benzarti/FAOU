<div class="table">
<table style="border-bottom:2px solid #009fff" class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
{{-- first column --}}
<table>
<tr>
<td>
<img src="{{asset('images/logo.png')}}" class="logo" alt="" width="75" height="75">
</td>
<td>
<h1>{{$name}}</h1>
<p style="margin:0px;">{{$position}}</p>
<p style="margin:0px;">Fatima Al-Fihri Open University</p>
</td>
</tr>
</table>
</td>
<td align="center">
{{-- second column --}}
<img src="{{asset('icons/phone.png')}}" class="mail_contact" alt="" height="10" width="10"> <a class="mail_text_contact" href="tel:{{$phone}}">{{$phone}}</a> || <a class="mail_text_contact" href="tel:+212620224060">+212620224060</a>
<br>
<img src="{{asset('icons/mail.png')}}" class="mail_contact" alt="" height="10" width="10"> <a class="mail_text_contact" href="mailto:contact@alfihri.org">contact@alfihri.org</a>
<br>
<img src="{{asset('icons/link.png')}}" class="mail_contact" alt="" height="10" width="10"> <a class="mail_text_contact" href="http://www.alfihri.org">www.alfihri.org</a>
<br>
<img src="{{asset('icons/location.png')}}" class="mail_contact" alt="" height="10" width="10"> <a class="mail_text_contact" href="http://">Tallinn, Estonia.</a>
</tr>
</table>
<div align="center" width="100%">
<a href="https://www.facebook.com/enFAOU"><img class="mail_links" src="{{asset('icons/facebook.png')}}" alt="facebook icon" height="20" width="20"></a>
<a href="https://twitter.com/enFAOU"><img class="mail_links" src="{{asset('icons/twitter.png')}}" alt="twitter icon" height="20" width="20"></a>
<a href="https://www.youtube.com/channel/UCpxOvkfMmAO5dzEVrweyF1g"><img class="mail_links" src="{{asset('icons/youtube.png')}}" alt="youtube icon" height="20" width="20"></a>
<a href="https://www.linkedin.com/company/enfaou/mycompany/"><img class="mail_links" src="{{asset('icons/linkedin.png')}}" alt="linkedin icon" height="20" width="20"></a>
<a href="https://www.instagram.com/enfaou/"><img class="mail_links" src="{{asset('icons/instagram.png')}}" alt="linkedin icon" height="20" width="20"></a>
</div>
</div>


{{-- 
<div class="table">
{{ Illuminate\Mail\Markdown::parse($slot) }}
</div> --}}
