@component('mail::message')
Account Creation for {{ config('app.name') }}


@component('mail::panel')
Please be notify of your Account on {{ config('app.name') }} successfully created <br>
Find below login Credentials to your Account.<br>
Username: <span style="color:blue"> {{ $user->email }}  </span> <br>
Password: <span style="color:blue">  password </span>
@endcomponent

Thanks,<br>
Admin Manager
{{ config('app.name') }}
@endcomponent
