<?php

namespace App\Mail;

use App\Models\User;

class AdminEmailChangeMail extends BaseUserMail
{
    /**
     * UserEmailChangeMail constructor.
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
        return $this->subject(trans('auth.change_your_email'))
            ->view('mails.admin-email-change.normal')
            ->text('mails.admin-email-change.plain');
    }
}
