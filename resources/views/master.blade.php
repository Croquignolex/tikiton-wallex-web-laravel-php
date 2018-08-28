<!DOCTYPE html>

<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Plugin CSS -->
        @stack('style.plugin')
        <link rel="stylesheet" href="{{ css_asset('animate') }}" type="text/css">
        <!-- Custom fonts for this template -->
        <link rel="stylesheet" href="{{ css_asset('fontawesome-all.min') }}" type="text/css">
        <!-- Global styles -->
        <link rel="stylesheet" href="{{ css_asset('master') }}" type="text/css">
        <!-- Custom styles for this page -->
        @stack('style.page')

        <!-- Favicons -->
        <link rel="icon" href="{{ favicon_img_asset('favicon-32x32') }}" sizes="32x32" type="image/png">
        <link rel="icon" href="{{ favicon_img_asset('favicon-16x16') }}" sizes="16x16" type="image/png">
    </head>

    <body>
        <div id="loader"></div>
        <div id="app">@yield('body')</div>
        @stack('script.plugin')
        <!-- Plugin JavaScript -->
        <script src="{{ js_asset('vue.min') }}" type="text/javascript"></script>
        <script src="{{ js_asset('bootstrap-notify.min') }}" type="text/javascript"></script>
        <!-- Global scripts -->
        <script src="{{ js_asset('master') }}" type="text/javascript"></script>
        <!-- Custom scripts for this page -->
        @stack('script.page')
        @include('partials.popup-alert')
    </body>
</html>