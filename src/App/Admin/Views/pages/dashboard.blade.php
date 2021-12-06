<x-admin-app-layout>
    <l-app
        :response-data="{{ Js::from(Session::pull('responseData')) }} || {}"
        :response-data-modal="{{ Js::from(Session::get('responseDataModal')) }} || {}"
    />
</x-admin-app-layout>
