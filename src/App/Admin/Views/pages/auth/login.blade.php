<x-admin-app-layout>
    <login link="{{ route('admin.web.password.recovery') }}" :response-data="{{ Js::from(Session::pull('responseData')) }} || {}"/>
</x-admin-app-layout>
