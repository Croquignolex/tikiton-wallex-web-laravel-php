{{ mb_strtoupper(trans('auth.email_validation')) }}


@lang('mail.top_register_msg', ['name' => $user->format_first_name]).

@lang('mail.body_change_email_msg' , ['date' => $user->long_created_date]).

<a href="{{ $user->confirmation_link }}" target="_blank">@lang('mail.validate_my_email')</a>

@lang('mail.bottom_register_msg', ['contact' => config('company.email_1')]).

@lang('general.admin_thanks', ['app' => config('app.name')])
&copy; 2018 {{ config('app.name') }}, @lang('general.right').