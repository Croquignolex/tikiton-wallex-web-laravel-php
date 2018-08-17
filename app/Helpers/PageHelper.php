<?php

if(!function_exists('page_title'))
{
    /**
     * @param $page
     * @return \Illuminate\Config\Repository|mixed|string
     */
    function page_title($page)
    {
        $base_name = config('app.name');
        return $page == '' ? $base_name : $page . ' - ' .  $base_name;
    }
}

if(!function_exists('active_page'))
{
    /**lightSpeedOut
     * @param \Illuminate\Support\Collection $routes
     * @param string $type
     * @return string
     */
    function active_page(\Illuminate\Support\Collection $routes, $type = '')
    {
        foreach ($routes as $route)
        {
            if(Illuminate\Support\Facades\Route::is($route))
            {
                return $type == 'expend'
                    ? 'show' : 'active';
            }
        }

        return '';
    }
}