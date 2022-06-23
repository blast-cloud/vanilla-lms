@component('mail::message')
{{ $input['title'] }}

@component('mail::panel')
{{ $input['message'] }}
@endcomponent

Thanks,<br>
Administration Desk
@endcomponent

