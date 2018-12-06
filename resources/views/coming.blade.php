@extends('layouts.master')

@section('title', 'coming soon')

@section('body')
    <div class="bg-img1 size1 overlay1 p-t-24">
        <div class="flex-w flex-sb-m p-l-80 p-r-74 p-b-175 respon5">
            <div class="wrappic1 m-r-30 m-t-10 m-b-10">
                <a href="{{ locale_route('home') }}"><img src="{{ img_asset('logo') }}" alt=".."></a>
            </div>
            <div class="flex-w m-t-10 m-b-10">
                <a href="#" class="size3 flex-c-m how-social trans-04 m-r-6 text-theme-1 border-theme-1">
                    <i class="fa fa-facebook"></i>
                </a>
                <a href="#" class="size3 flex-c-m how-social trans-04 m-r-6 text-theme-1 border-theme-1">
                    <i class="fa fa-twitter"></i>
                </a>
                <a href="#" class="size3 flex-c-m how-social trans-04 m-r-6 text-theme-1 border-theme-1">
                    <i class="fa fa-youtube-play"></i>
                </a>
            </div>
        </div>
        <div class="flex-w flex-sa respon1 text-center">
            <div class="p-t-34 p-b-60 respon3">
                <p class="l1-txt1 p-b-10 respon2">
                    Our wallets manager app is
                </p>
                <h3 class="l1-txt2 p-b-45 respon2 respon4">
                    Coming Soon
                </h3>
                <div class="cd100"></div>
            </div>
        </div>
    </div>
@endsection

@push('style.plugin')
    <link rel="stylesheet" href="{{ css_asset('coming/bootstrap.min') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_asset('coming/select2.min') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_asset('coming/flipclock') }}" type="text/css">
@endpush

@push('style.page')
    <link rel="stylesheet" href="{{ css_asset('coming/util') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_asset('coming/main') }}" type="text/css">
@endpush

@push('script.plugin')
    <script src="{{ js_asset('coming/jquery-3.2.1.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('coming/popper.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('coming/bootstrap.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('coming/select2.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('coming/flipclock.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('coming/moment.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('coming/moment-timezone.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('coming/moment-timezone-with-data.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('coming/countdowntime') }}" type="text/javascript"></script>
@endpush

@push('script.page')
    <script>
        $('.cd100').countdown100({
            /*Set Endtime here*/
            /*Endtime must be > current time*/
            endtimeYear: 0,
            endtimeMonth: 0,
            endtimeDate: 0,
            endtimeHours: 0,
            endtimeMinutes: 0,
            endtimeSeconds: 0,
            timeZone: ""
            // ex:  timeZone: "America/New_York"
            //go to " http://momentjs.com/timezone/ " to get timezone
        });
    </script>
    <script src="{{ js_asset('coming/tilt.jquery.min') }}" type="text/javascript"></script>
    <script >
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <script src="{{ js_asset('coming/main') }}" type="text/javascript"></script>
@endpush

