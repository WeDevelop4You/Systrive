<x-admin-app-layout>
    <login
        link="{{ route('admin.web.password.recovery') }}"
        :response-data="{{ Js::from(Session::pull('responseData')) }} || {}"
        :response-data-modal-login="{{ Js::from(Session::get('responseDataModalLogin')) }} || {}"
    />
</x-admin-app-layout>
