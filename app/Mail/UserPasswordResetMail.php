<?php

namespace App\Mail;

use App\Models\User;

class UserPasswordResetMail extends BaseUserMail
{
    /**
     * UserRegisterMail constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('auth.reset_your_pwd'))
            ->view('mails.user-password-reset.normal')
            ->text('mails.user-password-reset.plain');
    }
}
