@component('mail::message')
Password Reset for {{ $user->email }}


@component('mail::panel')
<span style="color:blue"> {{ $user->name }} </span>,  Please  be notify of your Account on {{ config('app.name') }} Password Reset <br>
Find below your New Password.<br>
Password: <span style="color:blue">  {{ $password }}</span>
@endcomponent

Thanks,<br>
Admin Manager
{{ config('app.name') }}
@endcomponent
