@component('mail::message')
Password Reset for {{ $user->email }}


@component('mail::panel')
<span style="color:blue"> {{ $user->name }} </span>, Please be notified that your account password has been reset. <br>
Find below your New Password.<br/>
Password: <span style="color:blue">{{ $password }}</span>
<br/>
Please keep your password safe.
@endcomponent

Thanks,<br>
Administrator
@endcomponent
