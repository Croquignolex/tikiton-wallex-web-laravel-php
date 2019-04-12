<!DOCTYPE html>

<html lang="{{ App::getLocale() }}">
    <head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-130585668-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-130585668-1');
		</script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
        @yield('body')
        @stack('script.plugin')
        <script src="{{ js_asset('vue.min') }}" type="text/javascript"></script>
        <script src="{{ js_asset('bootstrap-notify.min') }}" type="text/javascript"></script>
        <script src="{{ js_asset('jquery.easing.1.3') }}" type="text/javascript"></script>
        <script src="{{ js_asset('jquery.scrollUp.min') }}" type="text/javascript"></script>
        <script src="{{ js_asset('master') }}" type="text/javascript"></script>
        @stack('script.page')
        @include('partials.popup-alert')
        <script src="{{ js_asset('timezone-detect') }}" type="text/javascript"></script>
    </body>
</html>