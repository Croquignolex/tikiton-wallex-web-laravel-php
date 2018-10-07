@inject('languageService', 'App\Services\LanguageService')

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

                @endauth
                @guest
                    <li class="probootstra-cta-button last">
                        <a href="{{ locale_route('login') }}" class="btn btn-outline-theme-1">
                            <i class="fa fa-user"></i>
                            @lang('general.login')
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<!--End Header Area-->