@component('mail::message')
# Hello!

You are receiving this email because you are invited for {{ $name }}.

@component('mail::button', ['url' => $url])
    Join Here
@endcomponent

This link will expire in 7 days.

Thanks,<br>
{{ config('app.name') }}

<hr>

<small>If you're having trouble clicking the "Join Here" button, copy and paste the URL below into your web browser: {{ $url }}</small>
@endcomponent
