@extends('layouts.landing')

@section('landing.layout.title', page_title(trans('general.about')))

@section('page_name', trans('general.about_us'))

@section('page_desc', trans('general.about_desc'))

@section('page_icon')
    <i class="fa fa-info-circle"></i>
@endsection

@section('landing.layout.body')
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
                @forelse($teams as $team)
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
                @empty
                    <div class="col-sm-12 fix alert alert-info text-center">
                        @lang('general.no_teams')
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!--End Team Area-->
@endsection