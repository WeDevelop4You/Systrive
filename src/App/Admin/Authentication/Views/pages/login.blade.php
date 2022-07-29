<x-admin-app-layout>
    <login
        link="{{ route('admin.web.password.recovery') }}"
        :response-data="{{ Js::from(Session::pull('session_pull')) }} || {}"
    />
</x-admin-app-layout>
