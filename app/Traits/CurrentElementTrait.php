<?php

namespace App\Traits;

use App\Utils\FormatBoolean;

trait CurrentElementTrait
{
    /**
     * @return mixed
     */
    public function getFormatCurrentAttribute()
    {
        return $this->is_current
            ? new FormatBoolean('success', 'fa fa-check', trans('general.activated'))
            : new FormatBoolean('danger', 'fa fa-times', trans('general.not_activated'));
    }
}