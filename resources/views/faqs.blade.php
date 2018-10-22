@extends('layouts.landing')

@section('landing.layout.title', 'FAQs')

@section('page_name', 'FAQs')

@section('page_desc', trans('general.faqs'))

@section('page_icon')
    <i class="fa fa-question-circle"></i>
@endsection

@section('landing.layout.body')
    <!--Start FAQs Area-->
    <section class="probootstrap-section probootstrap-bg-white probootstrap-zindex-above-showcase">
        <div class="container">
            <!--Start Pagination Area-->
            <div class="row">
                <div class="col-md-12 text-right">
                    @component('components.pagination',
                        ['paginationTools' => $paginationTools])
                    @endcomponent
                </div>
            </div>
            <!--End Pagination Area-->
            <div class="row">
                @forelse($paginationTools->displayItems as $faq)
                    <div class="col-md-6 probootstrap-animate" data-animate-effect="fadeIn">
                        <h3>{{ $faq->format_question }}</h3>
                        <p>{{ $faq->format_answer }}</p>
                    </div>
                @empty
                    <div class="col-sm-12 fix alert alert-info text-center">
                        @lang('general.no_faqs')
                    </div>
                @endforelse
            </div>
            <!--Start Pagination Area-->
            <div class="row">
                <div class="col-md-12">
                    @component('components.pagination',
                        ['paginationTools' => $paginationTools])
                    @endcomponent
                </div>
            </div>
            <!--End Pagination Area-->
        </div>
    </section>
    <!--End FAQs Area-->
@endsection