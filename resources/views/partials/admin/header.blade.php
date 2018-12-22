@inject('notificationService', 'App\Services\NotificationService')
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
                            <a href="javascript: void(0);" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle" id="notification" @click="showNotifications">
                                <span><i class="fa fa-bell-o {{ $notificationService->getBlinkClass() }}"></i></span>
                                <div class="spinner4 spinner-4"></div>
                                <div class="ntd-ctn-{{ $notificationService->getBadgeColor() }}"><span>{{ $notificationService->getNotificationsNumber() }}</span></div>
                            </a>
                            <div role="menu" class="dropdown-menu message-dd notification-dd animated zoomIn">
                                <div class="hd-mg-tt">
                                    <h2 class="text-theme-1 text-uppercase">
                                        <strong>@lang('general.notifications')</strong>
                                    </h2>
                                </div>
                                <div class="hd-message-info">
                                    @forelse($notificationService->getNotifications() as $notification)
                                        <a href="{{ $notification->url }}">
                                            <div class="alert alert-default notification-line" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                                        onclick="document.getElementById('delete-notification-{{ $notification->id }}').submit();">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h5 class="text-{{ $notification->color }}">
                                                    <i class="fa fa-{{ $notification->icon }}"></i>
                                                    {{ $notification->details }}
                                                </h5>
                                                <h5 class="text-muted font-italic">
                                                    {{ $notification->long_created_date }}
                                                </h5>
                                            </div>
                                        </a>
                                        <form id="delete-notification-{{ $notification->id }}" action="{{ locale_route('notifications.destroy', [$notification]) }}" method="POST" class="hidden">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    @empty
                                        <div class="alert alert-info text-center" role="alert">
                                            @lang('general.no_data')
                                        </div>
                                    @endforelse
                                </div>
                                <div class="hd-mg-va">
                                    <a href="{{ route('admin.notifications.index') }}">@lang('general.view_all')</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link logout" href="javascript: void(0);" role="button" data-placement="bottom"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               data-content="@lang('general.log_out')" data-trigger="hover" data-toggle="popover">
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