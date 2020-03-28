@component('mail::message')
# Welcome {{$user->name}}!

Thank you for registering in **PFM Portal**. The system admministrator will review and assign you appropirate role.

@component('mail::panel')
  The email address you signed up with is: {{$user->email}}
@endcomponent

@component('mail::button', ['url' => 'pfm.besomv.com'])
PFM Portal
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
