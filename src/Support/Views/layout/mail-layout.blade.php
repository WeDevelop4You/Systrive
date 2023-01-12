@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img src="{{ asset('images/admin/inline-logo.png') }}" style="max-height: 75px" alt="{{ config('app.name') }}">
@endcomponent
@endslot

{{ $slot }}

{{ trans('Regards') }},<br>
{{ trans(':name team', ['name' => config('app.name')]) }}

@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. {{ trans('All rights reserved.') }}
@endcomponent
@endslot
@endcomponent
