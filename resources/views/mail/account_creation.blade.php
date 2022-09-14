@component('mail::message')
Your account has been created.

@component('mail::panel')
Please be notified that your Account has been successfully created <br>
Find below the login Credentials to your Account.<br>
Username: <span style="color:blue"> {{ $user->email }}  </span> <br>
Password: <span style="color:blue"> {{$password}} </span>
@endcomponent

Thanks,<br>
Administrator
@endcomponent
