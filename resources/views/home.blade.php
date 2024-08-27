<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="css/panel-style.css" rel="stylesheet">
</head>

<body>
    <div class="container full-height">
        <div class="row justify-content-center">
            <main class="col-md-5 position-relative zindex-1 py-5"><a href="/"
                    class="panel-logo router-link-exact-active active"></a>
                <div class="login-box">
                    <div class="login-box-title">پرتال Chival</div>
                    <div class="login-box-body">
                        <div class="col-12 mt-3 mb-3 text-center"><a href="client/login" class="btn btn-primary btn-lg">ورود به پرتال کاربری</a></div>
                        <div class="col-12 text-center"><a href="/portal/login" class="btn btn-primary btn-lg">ورود به پرتال مدیریت</a></div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>