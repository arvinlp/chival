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
    <div class="datamis-mobile-disabled d-md-none">
        <span class="logo"></span>
        <h2>{{ config('app.name', 'Laravel') }}</h2>
        <p>متاسفانه سرویس مورد نظر شما برای نمایش در این اندازه طراحی نشده است.</p>
    </div>
    <div id="app">
    </div>

    <!-- Scripts -->
    <script src="{{ env('ASSEST_URL') }}js/app.js" defer></script>
</body>
</html>
