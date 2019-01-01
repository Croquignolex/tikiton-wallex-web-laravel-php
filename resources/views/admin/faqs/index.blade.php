@extends('layouts.admin.breadcrumb')

@section('breadcrumb.admin.layout.title', admin_page_title('FAQs'))

@section('breadcrumb.title', 'FAQs')

@section('breadcrumb.message')
    <a href="{{ route('admin.faqs.index') }}">FAQs</a>
    ({{ $paginationTools->itemsNumber }})
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-question-circle"></i>
@endsection

@section('breadcrumb.admin.layout.body')
    <!--Start Users Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        @component('components.admin.pagination',
                            ['paginationTools' => $paginationTools])
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr class="text-uppercase">
                                    <th class="text-theme-2">#</th>
                                    <th class="text-theme-2">Question (fr)</th>
                                    <th class="text-theme-2">Question (en)</th>
                                    <th class="text-theme-2">Réponse (fr)</th>
                                    <th class="text-theme-2">Réponse (en)</th>
                                    <th class="text-theme-2">@lang('general.actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($paginationTools->displayItems as $faq)
                                    <tr>
                                        <td>{{ ($loop->index + 1) + ($paginationTools->itemsPerPage * ($paginationTools->currentPage - 1)) }}</td>
                                        <td>
                                            <span class="text-right" data-content="{{ $faq->fr_question }}" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                {{ text_format($faq->fr_question, 15) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-right" data-content="{{ $faq->en_question }}" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                {{ text_format($faq->en_question, 15) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-right" data-content="{{ $faq->fr_answer }}" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                {{ text_format($faq->fr_answer, 20) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-right" data-content="{{ $faq->en_answer }}" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                {{ text_format($faq->en_answer, 20) }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.faqs.show', [$faq]) }}" class="text-theme-2" title="@lang('general.details')"><i class="fa fa-eye"></i></a>&nbsp;
                                            <a href="{{ route('admin.faqs.edit', [$faq]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>&nbsp;
                                            <a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#delete-faqs-{{ $faq->id }}" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="6" class="text-center">
                                        <div class="text-center">
                                            <div class="alert alert-info text-center" role="alert">
                                                @lang('general.no_data')
                                            </div>
                                        </div>
                                    </td>
                                @endforelse
                                </tbody>
                                <thead>
                                <tr class="text-uppercase">
                                    <th class="text-theme-2">#</th>
                                    <th class="text-theme-2">Question (fr)</th>
                                    <th class="text-theme-2">Question (en)</th>
                                    <th class="text-theme-2">Réponse (fr)</th>
                                    <th class="text-theme-2">Réponse (en)</th>
                                    <th class="text-theme-2">@lang('general.actions')</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        @component('components.admin.pagination',
                            ['paginationTools' => $paginationTools])
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Users Area-->
@endsection



