@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.categories')))

@section('breadcrumb.title', trans('general.categories'))

@section('breadcrumb.message')
    <a href="{{ locale_route('categories.index') }}">@lang('general.categories')</a>
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-database"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Currencies Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.categories')])
                            @lang('tips.categories')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container">
                            <div class="widget-tabs-list">
                                <ul class="nav nav-tabs tab-nav-center">
                                    <li class="{{ $type == \App\Models\Category::INCOME ? 'active' : '' }}">
                                        <a data-toggle="tab" href="#income">
                                            <span class="text-success">
                                                <i class="fa fa-arrow-up"></i>
                                                @lang('general.income')
                                            </span>
                                        </a>
                                    </li>
                                    <li class="{{ $type == \App\Models\Category::TRANSFER ? 'active' : '' }}">
                                        <a data-toggle="tab" href="#transfer">
                                            <span class="text-info">
                                                <i class="fa fa-exchange"></i>
                                                @lang('general.transfer')
                                            </span>
                                        </a>
                                    </li>
                                    <li class="{{ $type == \App\Models\Category::EXPENSE ? 'active' : '' }}">
                                        <a data-toggle="tab" href="#expense">
                                            <span class="text-danger">
                                                <i class="fa fa-arrow-down"></i>
                                                @lang('general.expense')
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="income" class="tab-pane fade {{ $type == \App\Models\Category::INCOME ? 'in active' : '' }}">
                                        <div class="tab-ctn">
                                            @component('components.app.category-accordion', [
                                                'id' => 'incomeCategories',
                                                'categories' => $incomeCategories
                                            ])
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div id="transfer" class="tab-pane fade {{ $type == \App\Models\Category::TRANSFER ? 'in active' : '' }}">
                                        <div class="tab-ctn">
                                            @component('components.app.category-accordion', [
                                              'id' => 'transferCategories',
                                              'categories' => $transferCategories
                                            ])
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div id="expense" class="tab-pane fade {{ $type == \App\Models\Category::EXPENSE ? 'in active' : '' }}">
                                        <div class="tab-ctn">
                                            <div class="tab-ctn">
                                                @component('components.app.category-accordion', [
                                                   'id' => 'expenseCategories',
                                                   'categories' => $expenseCategories
                                                ])
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Currencies Area-->

    @foreach($categories as $category)
        @if($category->can_be_deleted)
            @component('components.modal', [
                'title' => trans('general.delete_category', ['name' => $category->name]),
                'id' => 'delete-category-' . $category->id, 'color' => 'modal-danger',
                'action_route' => locale_route('categories.destroy', [$category])
                ])
                @lang('general.cfm_action')?
            @endcomponent
        @endif
    @endforeach
@endsection



