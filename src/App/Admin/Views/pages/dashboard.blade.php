<x-admin-app-layout>
    <l-app
        :response-data="{{ Js::from(Session::pull('session_pull')) }} || {}"
        :response-data-keep="{{ Js::from(Session::get('session_get')) }} || {}"
    />
</x-admin-app-layout>
