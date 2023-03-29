@php $link = url('/login') @endphp
@component('mail::message')
Course Class Enrollment Notification.

@component('mail::panel')

You are Enrolled into Class <span style="color:blue">{{ $enrollment->courseClass->code }}::{{ $enrollment->courseClass->name }} </span> <br>
Being taught by <span style="color:blue"> {{ $enrollment->courseClass->lecturer->job_title }} {{ $enrollment->courseClass->lecturer->last_name }},  {{ $enrollment->courseClass->lecturer->first_name }} </span>  for the Semester <span style="color:blue"> {{ $enrollment->courseClass->semester->code }}  </span>
<br/>
Please kindly login to the portal to access this class.<br>
Link: <a href="{{$link}}" target="_blank">{{$link}}</a>
@endcomponent

Thanks,<br>
Department Manager
@endcomponent
