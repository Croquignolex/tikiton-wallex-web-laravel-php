<!-- Start modal -->
<div class="modal animated shake" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modals-default" role="document">
        <div class="modal-content {{ $color }}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4><strong>{{ $title }}</strong></h4>
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <div class="modal-footer">
                    @if(isset($action_route))
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"
                                onclick="document.getElementById('action-{{ $id }}').submit();">
                            <i class="fa fa-check"></i> @lang('general.yes')
                        </button>
                    @endif
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">
                        <i class="fa fa-times"></i> @lang('general.no')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($action_route))
    <form id="action-{{ $id }}" action="{{ $action_route }}" method="POST" class="hidden">
        {{ csrf_field() }}
        {{ method_field($method ?? 'DELETE') }}
    </form>
@endif