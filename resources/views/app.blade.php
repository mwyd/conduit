<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Shadowpay market csgo statistics viewer">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Conduit</title>
        <link rel="icon" type="image/x-icon" href="{{ url('favicon.ico') }}">
        @viteReactRefresh
        @vite('resources/js/app.tsx')
        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
</html>
