<!--Start Date Range Area-->
<div class="white-container">
    <form action="{{ locale_route('transactions.filter') }}" method="POST" @submit="validateFormElements">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                <div class="form-group">
                    @component('components.app.label-input', ['name' => 'begin_date'])
                        <div class="nk-int-st">
                            @component('components.input', [
                               'name' => 'begin_date',
                               'class' => 'form-control', 'value' => $begin_date
                               ])
                            @endcomponent
                        </div>
                    @endcomponent
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                <div class="form-group">
                    @component('components.app.label-input', ['name' => 'end_date'])
                        <div class="nk-int-st">
                            @component('components.input', [
                               'name' => 'end_date',
                               'class' => 'form-control', 'value' => $end_date
                               ])
                            @endcomponent
                        </div>
                    @endcomponent
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
                <div class="form-group">
                    <button type="submit" class="btn btn-theme-1 waves-effect" title="@lang('general.filter')">
                        <i class="fa fa-filter"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<!--End Date Range Area-->