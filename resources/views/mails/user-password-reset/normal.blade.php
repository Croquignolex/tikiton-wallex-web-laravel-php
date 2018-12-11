@extends('layouts.mail')

@section('head', mb_strtoupper(trans('auth.reset_pwd')))

@section('body')
    <tr>
        <td>
            <p style="text-align: justify;">
                <strong>
                    @lang('mail.top_password_reset_msg', ['name' => $user->format_first_name]).
                </strong>
            </p>
            <p style="text-align: justify;">
                @lang('mail.body_password_reset_msg' , ['date' => $user->long_created_date]).
            </p>
            <div style="text-align: center;">
                <a href="{{ $user->reset_link }}" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #da2013; text-decoration:none;" target="_blank">
                    @lang('mail.reset_my_password')
                </a>
            </div>
            <p style="text-align: justify;">
                @lang('mail.bottom_register_msg', [
                    'contact' => config('company.email_1')
                ]).
            </p>
        </td>
    </tr>
@endsection

