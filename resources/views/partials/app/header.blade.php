<!--Start Header Area-->
<div class="header-top-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="logo-area">
                    <a href="{{ locale_route('home') }}"><img src="{{ img_asset('logo') }}" alt="..." /></a>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="header-top-menu">
                    <ul class="nav navbar-nav notika-top-nav">
                        <li class="nav-item dropdown">
                            <a href="javascript: void(0);" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                <span><i class="fa fa-envelope-o"></i></span>
                                @if(false)
                                    <div class="spinner4 spinner-4"></div>
                                @endif
                                <div class="ntd-ctn-success"><span>0</span></div>
                            </a>
                            <div role="menu" class="dropdown-menu message-dd animated zoomIn">
                                <div class="hd-mg-tt">
                                    <h2 class="text-theme-1 text-uppercase">
                                        <strong>@lang('general.messages')</strong>
                                    </h2>
                                </div>
                                <div class="hd-message-info">
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="{{ img_asset('logo') }}" alt="..." />
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>David Belle</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="hd-mg-va">
                                    <a href="#">@lang('general.view_all')</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="javascript: void(0);" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                <span><i class="fa fa-bell-o flash-theme"></i></span>
                                <div class="spinner4 spinner-4"></div>
                                <div class="ntd-ctn-danger"><span>4</span></div>
                            </a>
                            <div role="menu" class="dropdown-menu message-dd notification-dd animated zoomIn">
                                <div class="hd-mg-tt">
                                    <h2 class="text-theme-1 text-uppercase">
                                        <strong>@lang('general.notifications')</strong>
                                    </h2>
                                </div>
                                <div class="hd-message-info">
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="{{ img_asset('logo') }}" alt="..." />
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>David Belle</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="hd-mg-va">
                                    <a href="#">@lang('general.view_all')</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="javascript: void(0);" role="button" title="@lang('general.log_out')"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off"></i>
                            </a>
                            <form id="logout-form" action="{{ locale_route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Header Area-->