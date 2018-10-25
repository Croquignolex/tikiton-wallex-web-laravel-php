<!DOCTYPE html>

<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        @stack('style.plugin')
        <link rel="stylesheet" href="{{ css_asset('animate') }}" type="text/css">
        <link rel="stylesheet" href="{{ css_asset('font-awesome.min') }}" type="text/css">
        <link rel="stylesheet" href="{{ css_asset('master') }}" type="text/css">
        @stack('style.page')

        <!--Start Favicon Area-->
        <link rel="icon" href="{{ favicon_img_asset('favicon-32x32') }}" sizes="32x32" type="image/png">
        <link rel="icon" href="{{ favicon_img_asset('favicon-16x16') }}" sizes="16x16" type="image/png">
        <!--End Favicon Are-->
    </head>

    <body>
        <div id="loader"></div>
        <div id="app">@yield('body')</div>
        @stack('script.plugin')
        <script src="{{ js_asset('vue.min') }}" type="text/javascript"></script>
        <script src="{{ js_asset('bootstrap-notify.min') }}" type="text/javascript"></script>
        <script src="{{ js_asset('jquery.scrollUp.min') }}" type="text/javascript"></script>
        <script src="{{ js_asset('master') }}" type="text/javascript"></script>
        @stack('script.page')
        @if(session()->has('notification.message'))
            <script>
                notification(
                    "{{ session('notification.title') }}",
                    "{{ session('notification.message') }}",
                    "{{ session('notification.type') }}",
                    "{{ session('notification.icon') }}",
                    "{{ session('notification.animate.enter') }}",
                    "{{ session('notification.animate.exit') }}",
                    "{{ session('notification.delay') }}"
                );
            </script>
        @endif
    </body>
</html>