<!--Start Report Modal Area-->
<div class="modal animated rubberBand" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modals-default" role="document">
        <div class="modal-content modal-default">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h5 class="text-uppercase"><strong>{{ $title }}</strong></h5>
                <div class="row">
                    <a href="{{ $route }}?type={{ \App\Models\Transaction::DAILY }}"
                       class="waves-effect col-xs-6 text-center modal-action">
                        <i class="fa fa-clock-o"></i>
                        @lang('general.daily')
                    </a>
                    <a href="{{ $route }}?type={{ \App\Models\Transaction::WEEKLY }}"
                       class="waves-effect col-xs-6 text-center modal-action">
                        <i class="fa fa-calendar-check-o"></i>
                        @lang('general.weekly')
                    </a>
                    <a href="{{ $route }}?type={{ \App\Models\Transaction::MONTHLY }}"
                       class="waves-effect col-xs-6 text-center modal-action">
                        <i class="fa fa-calendar-o"></i>
                        @lang('general.monthly')
                    </a>
                    <a href="{{ $route }}?type={{ \App\Models\Transaction::YEARLY }}"
                       class="waves-effect col-xs-6 text-center modal-action">
                        <i class="fa fa-calendar"></i>
                        @lang('general.yearly')
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Report Modal Area-->