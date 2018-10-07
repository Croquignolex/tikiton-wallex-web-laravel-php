@extends('layouts.layout')

@section('layout.title', page_title(trans('general.about')))

@section('layout.body')
    <!--Start Page Name Area-->
    <section class="probootstrap-hero probootstrap-xs-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-8 text-left probootstrap-hero-text probootstrap-animate" data-animate-effect="fadeIn">
                    <h1 class="text-theme-1"><i class="fa fa-info-circle"></i> About Us</h1>
                    <p>@lang('general.about_desc')</p>
                </div>
            </div>
        </div>
    </section>
    <!--End Page Name Area-->

    <!--Start About Area-->
    <section class="probootstrap-section probootstrap-bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6  section-heading probootstrap-animate">
                    <h2>@lang('general.our_vision')</h2>
                    <p>@lang('general.our_vision_desc', ['company' => mb_strtoupper(config('company.name'))])</p>
                </div>
                <div class="col-md-6  section-heading probootstrap-animate">
                    <h2>@lang('general.our_mission')</h2>
                    <p>
                        @lang('general.our_mission_desc', [
                            'company' => mb_strtoupper(config('company.name')),
                            'app' => mb_strtoupper(config('app.name'))
                         ])
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!--End About Area-->

    <!--Start Team Area-->
    <section class="probootstrap-section probootstrap-bg-white probootstrap-border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6 section-heading probootstrap-animate">
                    <h2>@lang('general.our_team')</h2>
                    <p> @lang('general.our_team_desc')</p>
                </div>
            </div>
            <div class="row">
                @foreach($teams as $team)
                    <div class="col-md-3 col-sm-6 col-xs-6 probootstrap-animate">
                        <a href="javascript: void(0);" class="probootstrap-team">
                            <img src="{{ $team->image_path }}" alt="..." class="img-responsive">
                            <div class="probootstrap-team-info">
                                <h3>
                                    <strong>{{ $team->format_name }}</strong>
                                    <span class="position">
                                        <strong>{{ $team->format_function }}</strong>
                                    </span>
                                </h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--End Team Area-->
@endsection