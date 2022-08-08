<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('app.name') }}</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite('resources/css/admin/app.css')
        @vite('resources/css/admin/custom.css')

        @vite('resources/js/admin/app.js')
    </head>
    <body>
        <div id="mount">
            {{ $slot }}
        </div>
    </body>
</html>
