<?php

namespace App\Mail;

use App\Models\User;

class NewConfirmedUserMail extends BaseUserMail
{
    /**
     * NewCustomerMail constructor.
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
        return $this->subject('Nouvel utilisateur confirmé')
            ->view('mails.new-confirmed-user.normal')
            ->text('mails.new-confirmed-user.plain');
    }
}
