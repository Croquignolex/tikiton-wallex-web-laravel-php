@if(\Illuminate\Support\Facades\Auth::user()->user_settings->where('is_current', true)->first()->tips)
    <div class="alert alert-info alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4><strong><i class="fa fa-info-circle"></i> {{ $title }}</strong></h4>
        {{ $slot  }}
    </div>
@endif