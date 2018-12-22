<?php

namespace App\Traits;

use Exception;
use App\Models\Role;
use App\Models\User;

trait ResetPasswordUserTrait
{
    /**
     * @param array $credentials
     * @return null
     */
    protected function getUser(array $credentials)
    {
        try
        {
            $user = User::where(['email' => $credentials['email']])->first();
            if($user !== null) if($user->role->type === Role::USER) return $user;
            return null;
        }
        catch(Exception $exception)
        {
            $this->databaseError($exception);
            return null;
        }
    }
}