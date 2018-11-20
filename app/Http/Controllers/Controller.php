<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $date
     * @return Carbon
     */
    protected function carbonFormatDate($date)
    {
        $locale = App::getLocale();
        if($locale === 'en')
            return Carbon::createFromFormat('m/d/Y h:i A', $date);
        else if($locale === 'fr')
            return Carbon::createFromFormat('d/m/Y H:i', $date);

        return Carbon::now();
    }
}
