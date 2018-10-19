<?php

namespace App\Traits;

use Exception;

trait ErrorFlashMessagesTrait
{
    /**
     * @param Exception $exception
     */
    protected function databaseError(Exception $exception)
    {
        $this->flashError('database_error', $exception);
    }

    /**
     * @param Exception $exception
     */
    protected function mailError(Exception $exception)
    {
        $this->flashError('mail_error', $exception);
    }

    /**
     * @param Exception $exception
     */
    protected function imageError(Exception $exception)
    {
        $this->flashError('image_error', $exception);
    }

    /**
     * @param $locale_message
     * @param Exception $exception
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function flashError($locale_message, Exception $exception)
    {
        if(config('app.debug'))
        {
            $message = trans('general.' . $locale_message) .
                '. ' . $exception->getMessage();
        }
        else $message = trans('general.' . $locale_message);

        danger_flash_message(trans('auth.error'), $message);
        return back();
    }
}