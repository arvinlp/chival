<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ env('ASSEST_URL') }}css/panel-style.css" rel="stylesheet">
</head>
<body>
    <div id="app">
    </div>

    <!-- Scripts -->
    <script src="{{ env('ASSEST_URL') }}js/app-portal.js" defer></script>
</body>
</html>
