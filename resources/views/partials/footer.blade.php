@inject('languageService', 'App\Services\LanguageService')

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