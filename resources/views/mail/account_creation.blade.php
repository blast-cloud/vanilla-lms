@component('mail::message')
Your account has been created.

@component('mail::panel')
Please be notify of your Account successfully created <br>
Find below login Credentials to your Account.<br>
Username: <span style="color:blue"> {{ $user->email }}  </span> <br>
Password: <span style="color:blue"> password </span>
@endcomponent

Thanks,<br>
Administrator
@endcomponent
