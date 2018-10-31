<!--Start Site Info Area-->
<meta name="description" content="{{ seo_description() }}" />
<meta name="keywords" content="{{ seo_keywords() }}" />
<meta name="dcterms.publisher" content="{{ config('app.name') }}" />
<meta name="dcterms.modified" title="W3CDTF" content="{{ now() }}">
<meta name="dcterms.title" content="@yield('layout.title')" />
<meta name="dcterms.subject" title="scheme" content="{{ seo_keywords() }}" />
<meta name="dcterms.language" title="ISO639-2" content="{{ App::getLocale() }}" />
<meta property="og:locale" content="{{ App::getLocale() }}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="@yield('layout.title')" />
<meta property="og:updated_time" content="{{ now() }}" />
<meta property="og:description" content="{{ seo_description() }}" />
<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:image" content="{{ favicon_img_asset('favicon-32x32') }}" />
<meta property="og:url" content="{{ config('app.url') }}" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="{{ seo_description() }}" />
<meta name="twitter:title" content="@yield('layout.title')" />
<meta name="twitter:image" content="{{ img_asset('logo') }}" />
<meta name="twitter:site" content="@wallex">
<link rel="shortcut icon" href="{{ favicon_img_asset('favicon-32x32') }}" />
<link rel="apple-touch-icon" href="{{ img_asset('logo') }}" />
<meta name="google-site-verification" content="google5a1972c41b2ad0da" />
<meta name="google" content="noimageindex">
<meta name="google" content="notranslate" />
<meta name="robots" content="noarchive">
<meta name="robots" content="noodp">
<meta name="robots" content="noydir">
<!--End Site Info Area-->