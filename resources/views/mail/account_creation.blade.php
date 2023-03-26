@php $link = url('/login') @endphp
@component('mail::message')
Your account has been created.

@component('mail::panel')
Please be notified that your Account has been successfully created. <br>
Find below the login Credentials to your Account and Link to the platform.<br>
Email: <span style="color:blue"> {{ $user->email }}  </span> <br>
Password: <span style="color:blue"> {{$password}} </span> <br>
Link: <a href="{{$link}}" target="_blank">{{$link}}</a>
@endcomponent

Thanks,<br>
Administrator
@endcomponent
