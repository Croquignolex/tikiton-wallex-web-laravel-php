<!--Start Transaction Modal Area-->
<div class="modal animated rubberBand" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modals-default" role="document">
        <div class="modal-content modal-invisible">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4 text-center">
                        <a href="{{ $route }}?type={{ \App\Models\Category::INCOME }}"
                           class="transaction-modal-action waves-effect">
                            <span class="text-success">
                                <i class="fa fa-arrow-up"></i>
                                @lang('general.new_income_transaction')
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="{{ $route }}?type={{ \App\Models\Category::TRANSFER }}"
                           class="transaction-modal-action waves-effect">
                            <span class="text-info">
                                <i class="fa fa-exchange"></i>
                                @lang('general.new_transfer_transaction')
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="{{ $route }}?type={{ \App\Models\Category::EXPENSE }}"
                           class="transaction-modal-action waves-effect">
                            <span class="text-danger">
                                <i class="fa fa-arrow-down"></i>
                                @lang('general.new_expense_transaction')
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Transaction Modal Area-->