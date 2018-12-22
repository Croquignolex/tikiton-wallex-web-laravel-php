<?php

namespace App\Mail;

use App\Models\User;

class AdminPasswordResetMail extends BaseUserMail
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
            ->view('mails.admin-password-reset.normal')
            ->text('mails.admin-password-reset.plain');
    }
}
