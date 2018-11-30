<!--Start Transaction Modal Area-->
<div class="modal animated bounceIn" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modals-default" role="document">
        <div class="modal-content modal-default">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h5 class="text-uppercase"><strong>{{ $title }}</strong></h5>
                <div class="row">
                    <a href="{{ $route }}?type={{ \App\Models\Category::INCOME }}"
                       class="col-xs-4 text-center waves-effect modal-action">
                        <i class="fa fa-arrow-up text-success"></i>
                        @lang('general.new_income_transaction')
                    </a>
                    <a href="{{ $route }}?type={{ \App\Models\Category::TRANSFER }}"
                       class="col-xs-4 text-center waves-effect modal-action">
                        <i class="fa fa-exchange text-info"></i>
                        @lang('general.new_transfer_transaction')
                    </a>
                    <a href="{{ $route }}?type={{ \App\Models\Category::EXPENSE }}"
                       class="col-xs-4 text-center waves-effect modal-action">
                        <i class="fa fa-arrow-down text-danger"></i>
                        @lang('general.new_expense_transaction')
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Transaction Modal Area-->