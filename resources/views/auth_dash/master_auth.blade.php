<!doctype html>
<html lang="fa" direction="rtl" dir="rtl" style="direction: rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('auth_admin_title')</title>
@include('auth_dash.header_styles')
</head>
<body class="admin-section w3-flat-clouds">
@yield('main_content')
@include('auth_dash.footer_scripts')
@stack('custom_scripts')
</body>
</html>

