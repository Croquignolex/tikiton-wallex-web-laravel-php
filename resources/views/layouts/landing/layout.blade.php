@inject('languageService', 'App\Services\LanguageService')

@extends('layouts.master')

@section('title')
    @yield('layout.title')
@endsection

@section('body')
    <!--Start Header Area-->
    <nav class="navbar probootstrap-megamenu navbar-default probootstrap-navbar">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ locale_route('home') }}">{{ config('app.name') }}</a>
            </div>

            <div id="navbar-collapse" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="javascript: void(0);" data-toggle="dropdown" class="dropdown-toggle">
                        <span>
                            <img src="{{ flag_img_asset($languageService->getCurrentLanguage()) }}" alt="...">
                            @lang($languageService->getLanguageFullName($languageService->getCurrentLanguage()))
                        </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($languageService->getLanguages() as $language)
                                <li>
                                    <a href="{{ $languageService->isActiveLanguage($language) ? 'javascript: void(0);' : $languageService->getUrl($language) }}"
                                       title="{{ $languageService->getTitle($language) }}">
                                        <img src="{{ flag_img_asset($language) }}" alt="...">
                                        @lang($languageService->getLanguageFullName($language))
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="{{ active_page(about_pages()) }}"><a href="{{ locale_route('about') }}">@lang('general.about_us')</a></li>
                    <li class="{{ active_page(faqs_pages()) }}"><a href="{{ locale_route('faqs') }}">FAQs</a></li>
                    <li class="{{ active_page(contact_pages()) }}"><a href="{{ locale_route('contact') }}">@lang('general.contact_us')</a></li>
                    @auth
                        <li class="probootstra-cta-button last">
                            <a href="{{ locale_route('dashboard') }}" class="btn btn-outline-theme-1">
                                <i class="fa fa-user"></i>
                                {{ \Illuminate\Support\Facades\Auth::user()->format_first_name }}
                            </a>
                        </li>
                    @endauth
                    @guest
                        <li class="probootstra-cta-button last">
                            <a href="{{ locale_route('login') }}" class="btn btn-outline-theme-1">
                                <i class="fa fa-unlock"></i>
                                @lang('general.login')
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <!--End Header Area-->

    @yield('layout.body')

    <!--Start Contact Area-->
    <section class="probootstrap-cta">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="probootstrap-animate" data-animate-effect="fadeInRight">@lang('general.contact_us_desc')</h2>
                    <a href="{{ locale_route('contact') }}" role="button" class="btn btn-primary btn-lg btn-ghost probootstrap-animate" data-animate-effect="fadeInLeft">@lang('general.contact_us')</a>
                </div>
            </div>
        </div>
    </section>
    <!--End Contact Area-->

    <!--Start Footer Area-->
    <footer class="probootstrap-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-5 probootstrap-animate">
                            <div class="probootstrap-footer-widget">
                                <h3>@lang('language.languages')</h3>
                                <ul>
                                    @foreach($languageService->getLanguages() as $language)
                                        <li>
                                            <a href="{{ $languageService->isActiveLanguage($language) ? 'javascript: void(0);' : $languageService->getUrl($language) }}"
                                               title="{{ $languageService->getTitle($language) }}">
                                                <img src="{{ flag_img_asset($language) }}" alt="...">
                                                @lang($languageService->getLanguageFullName($language))
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-7 probootstrap-animate">
                            <div class="probootstrap-footer-widget">
                                <h3>@lang('general.useful_links')</h3>
                                <ul>
                                    <li><a href="{{ locale_route('about') }}">@lang('general.about_us')</a></li>
                                    <li><a href="{{ locale_route('faqs') }}">FAQs</a></li>
                                    <li><a href="{{ locale_route('contact') }}">@lang('general.contact_us')</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-5 probootstrap-animate">
                            <div class="probootstrap-footer-widget">
                                <h3>@lang('general.important_notes')</h3>
                                <ul>
                                    <li><a href="{{ locale_route('terms') }}">@lang('general.terms_of_uses')</a></li>
                                    <li><a href="{{ locale_route('policy') }}">@lang('general.privacy_policy')</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-7 probootstrap-animate">
                            <div class="probootstrap-footer-widget">
                                <h3>{{ config('company.name') }} {{ config('app.name') }}</h3>
                                <p>@lang('general.app_description', ['app' => config('app.name') ])</p>
                                <ul class="probootstrap-footer-social">
                                    <li><a href="{{ config('company.twitter') }}"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="{{ config('company.facebook') }}"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="{{ config('company.google_plus') }}"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="{{ config('company.linked_in') }}"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="{{ config('company.youtube') }}"><i class="fa fa-youtube-play"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 copyright">
                    <p><small>&copy; 2019 <a href="{{ config('company.web_site') }}">{{ config('company.name') }}</a>. @lang('general.right'). <br> @lang('general.designed_developed_with') <i class="fa fa-heart"></i> @lang('general.by') <a href="{{ config('company.developer_web_site') }}">{{ config('company.developer_name') }}</a></small></p>
                </div>
            </div>
        </div>
    </footer>
    <!--End Footer Area-->
@endsection

@push('style.plugin')
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

    <!--Start CSS Plugins Area-->
    <link rel="stylesheet" href="{{ css_asset('bootstrap.min') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_asset('animsition.min') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_asset('aos') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_asset('owl.carousel.min') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_asset('owl.theme.default.min') }}" type="text/css">
    <!--End CSS Plugins Area-->
@endpush

@push('style.page')
    <!--Start Page Style Area-->
    <link rel="stylesheet" href="{{ css_asset('style') }}" type="text/css">
    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--End Page Style Area-->
@endpush

@push('script.plugin')
    <!--Start JS Plugins Area-->
    <script src="{{ js_asset('jquery.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('bootstrap.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('animsition.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('aos') }}" type="text/javascript"></script>
    <script src="{{ js_asset('owl.carousel.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('jquery.countTo') }}" type="text/javascript"></script>
    <script src="{{ js_asset('jquery.appear') }}" type="text/javascript"></script>
    <script src="{{ js_asset('jquery.easing.1.3') }}" type="text/javascript"></script>
    <script src="{{ js_asset('jquery.stellar.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('jquery.waypoints.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('respond.min') }}" type="text/javascript"></script>
    <!--End JS Plugins Area-->
@endpush

@push('script.page')
    <!--Start Page Scripts Area-->
    <script src="{{ js_asset('script') }}" type="text/javascript"></script>
    @stack('layout.script.page')
    <!--End Page Scripts Area-->
@endpush