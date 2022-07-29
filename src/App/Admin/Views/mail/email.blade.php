@component('admin::layout.mail-layout')
# {{ trans('Verify email address') }}!

{{ trans('your email address has been changed to :email', ['email' => $email]) }}

{{ trans("If you didn't change your , we're here to tell you that you are fucked") }}
@endcomponent
