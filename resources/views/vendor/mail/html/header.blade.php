<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="{{asset('images/llogo.png')}}" class="llogo" alt="" style="width:300px;height:75px;max-height:75px;">
@endif
</a>
</td>
</tr>
