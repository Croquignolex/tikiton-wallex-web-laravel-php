@extends('layouts.layout')

@section('layout.title', page_title(trans('general.home')))

@section('layout.body')
    <!--Start Banner Area-->
    <section class="probootstrap-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 text-center probootstrap-hero-text pb0 probootstrap-animate" data-animate-effect="fadeIn">
                    <h1>@lang('general.banner_bold_text')</h1>
                    <p>@lang('general.banner_small_text')</p>
                    <p>
                        <a href="{{ locale_route('register') }}" class="btn btn-theme-1 btn-lg bounce-theme" role="button">
                            @lang('general.getting_started')
                        </a>
                    </p>
                    <p>
                        <a href="javascript: void(0);">
                            <i class="fa fa-play"></i>
                            @lang('general.watch_video')
                        </a>
                    </p>
                </div>
            </div>

            <div class="row probootstrap-feature-showcase">
                <div class="col-md-4 col-md-push-8 probootstrap-showcase-nav probootstrap-animate">
                    <ul>
                        <li class="active">
                            <a href="javascript: void(0);">
                                <i class="fa fa-crosshairs"></i>
                                @lang('general.responsive_design')
                            </a>
                            <p>@lang('general.responsive_design_desc', ['app' => mb_strtoupper(config('app.name'))])</p>
                        </li>
                        <li>
                            <a href="javascript: void(0);">
                                <i class="fa fa-pencil-alt"></i>
                                @lang('general.easy_language')
                            </a>
                            <p>@lang('general.easy_language_desc', ['app' => mb_strtoupper(config('app.name'))])</p>
                        </li>
                        <li>
                            <a href="javascript: void(0);">
                                <i class="fa fa-star"></i>
                                @lang('general.smooth_design')
                            </a>
                            <p>@lang('general.smooth_design_desc', ['app' => mb_strtoupper(config('app.name'))])</p>
                        </li>
                        <li>
                            <a href="javascript: void(0);">
                                <i class="fa fa-sitemap"></i>
                                @lang('general.panoramic_view')
                            </a>
                            <p>@lang('general.panoramic_view_desc', ['app' => mb_strtoupper(config('app.name'))])</p>
                        </li>
                        <li>
                            <a href="javascript: void(0);">
                                <i class="fa fa-wrench"></i>
                                @lang('general.full_control')
                            </a>
                            <p>@lang('general.full_control_desc', ['app' => mb_strtoupper(config('app.name'))])</p>
                        </li>
                        <li>
                            <a href="javascript: void(0);">
                                <i class="fa fa-cog"></i>
                                @lang('general.fast_data_processing')
                            </a>
                            <p>@lang('general.fast_data_processing_desc', ['app' => mb_strtoupper(config('app.name'))])</p>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8 col-md-pull-4 probootstrap-animate" style="position: relative;">
                    <div class="probootstrap-home-showcase-wrap">
                        <div class="probootstrap-home-showcase-inner">
                            <div class="probootstrap-chrome">
                                <div><span></span><span></span><span></span></div>
                            </div>
                            <div class="probootstrap-image-showcase">
                                <ul class="probootstrap-images-list">
                                    <li class="active"><img src="{{ img_asset('app-preview-1', 'jpg') }}" alt="Image" class="img-responsive"></li>
                                    <li><img src="{{ img_asset('app-preview-2', 'jpg') }}" alt="Image" class="img-responsive"></li>
                                    <li><img src="{{ img_asset('app-preview-1', 'jpg') }}" alt="Image" class="img-responsive"></li>
                                    <li><img src="{{ img_asset('app-preview-2', 'jpg') }}" alt="Image" class="img-responsive"></li>
                                    <li><img src="{{ img_asset('app-preview-1', 'jpg') }}" alt="Image" class="img-responsive"></li>
                                    <li><img src="{{ img_asset('app-preview-2', 'jpg') }}" alt="Image" class="img-responsive"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--End Banner Area-->

    <!--Start Features Area-->
    <section class="probootstrap-section probootstrap-bg-white probootstrap-zindex-above-showcase">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center section-heading probootstrap-animate" data-animate-effect="fadeIn">
                    <h2>@lang('general.features')</h2>
                    <p class="lead">@lang('general.features_desc', ['app' => config('app.name')])</p>
                </div>
            </div>
            <!-- END row -->
            <div class="row probootstrap-gutter60">
                <div class="col-md-4 probootstrap-animate" data-animate-effect="fadeInLeft">
                    <div class="service text-center">
                        <div class="icon"><i class="fa fa-credit-card"></i></div>
                        <div class="text">
                            <h3>@lang('general.wallet_management')</h3>
                            <p>@lang('general.wallet_management_desc')</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 probootstrap-animate" data-animate-effect="fadeInRight">
                    <div class="service text-center">
                        <div class="icon"><i class="fa fa-cogs"></i></div>
                        <div class="text">
                            <h3>@lang('general.account_management')</h3>
                            <p>@lang('general.account_management_desc')</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 probootstrap-animate" data-animate-effect="fadeIn">
                    <div class="service text-center">
                        <div class="icon"><i class="fa fa-money-bill-alt"></i></div>
                        <div class="text">
                            <h3>@lang('general.currency_management')</h3>
                            <p>@lang('general.currency_management_desc')</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 probootstrap-animate" data-animate-effect="fadeInLeft">
                    <div class="service text-center">
                        <div class="icon"><i class="fa fa-exchange-alt"></i></div>
                        <div class="text">
                            <h3>@lang('general.transaction_management')</h3>
                            <p>@lang('general.transaction_management_desc')</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 probootstrap-animate" data-animate-effect="fadeInUp">
                    <div class="service text-center">
                        <div class="icon"><i class="fa fa-file"></i></div>
                        <div class="text">
                            <h3>@lang('general.repport')</h3>
                            <p>@lang('general.repport_desc')</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 probootstrap-animate" data-animate-effect="fadeInRight">
                    <div class="service text-center">
                        <div class="icon"><i class="fa fa-chart-pie"></i></div>
                        <div class="text">
                            <h3>@lang('general.dashboard')</h3>
                            <p>@lang('general.dashboard_desc')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Features Area-->

    <!--Start Testimonials Area-->
    <section class="probootstrap-section probootstrap-border-top probootstrap-bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center section-heading probootstrap-animate">
                    <h2>@lang('general.what_people_says')</h2>
                    <p class="lead">@lang('general.what_people_says_desc', ['app' => config('app.name')])</p>
                </div>
            </div>
            <div class="row">
                @foreach($testimonials as $testimonial)
                    <div class="col-md-4 probootstrap-animate" data-animate-effect="fadeIn">
                        <div class="probootstrap-testimony-wrap text-center">
                            <figure>
                                <img src="{{ $testimonial->image_path }}" alt="...">
                            </figure>
                            <blockquote class="quote">&ldquo;{{ $testimonial->format_description }}”
                                <cite class="author">&mdash; {{ $testimonial->format_name }}
                                    <br> <span>{{ $testimonial->format_function }}</span>
                                </cite>
                            </blockquote>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--End Testimonials Area-->

    <!--Start Partners Area-->
    <section class="probootstrap-section proboostrap-clients probootstrap-bg-white probootstrap-border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6 section-heading probootstrap-animate">
                    <h2>@lang('general.our_partners')</h2>
                    <p class="lead">@lang('general.our_partners_desc')</p>
                </div>
            </div>
            <div class="row">
                @foreach($partners as $partner)
                    <div class="col-md-3 col-sm-6 col-xs-6 text-center client-logo probootstrap-animate" data-animate-effect="fadeIn">
                        <img src="{{ $partner->image_path }}" class="img-responsive" alt="...">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--End Partners Area-->

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
@endsection