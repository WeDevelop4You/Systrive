<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('app.name') }}</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="{{ asset('images/admin/icon.png') }}">
        <link rel="stylesheet" href="{{ mix('css/admin/app.css') }}">
        <link rel="stylesheet" href="{{ mix('css/admin/custom.css') }}">

        <script src="{{ mix('js/admin/app.js') }}" defer></script>
    </head>
    <body>
        <div id="app">
            {{ $slot }}
        </div>
    </body>
</html>
