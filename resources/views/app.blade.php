<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('APP_NAME') }}</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="{{ asset('images/icon.png') }}">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        <div id="app">
            <app-init></app-init>
        </div>
    </body>
</html>
