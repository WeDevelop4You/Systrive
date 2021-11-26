<x-admin-app-layout>
    <l-app :response-data="{{ Js::from(Session::pull('responseData')) }} || {}"/>
</x-admin-app-layout>
