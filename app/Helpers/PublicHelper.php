<?php

if(!function_exists('css_asset'))
{
    /**
     * @param $css_file
     * @return string
     */
    function css_asset($css_file)
    {
        return '/assets/css/' . $css_file . '.css';
    }
}

if(!function_exists('css_app_asset'))
{
    /**
     * @param $css_file
     * @return string
     */
    function css_app_asset($css_file)
    {
        return '/assets/css/app/' . $css_file . '.css';
    }
}

if(!function_exists('css_admin_asset'))
{
    /**
     * @param $css_file
     * @return string
     */
    function css_admin_asset($css_file)
    {
        return '/assets/css/admin/' . $css_file . '.css';
    }
}

if(!function_exists('js_asset'))
{
    /**
     * @param $js_file
     * @return string
     */
    function js_asset($js_file)
    {
        return  '/assets/js/' . $js_file . '.js';
    }
}

if(!function_exists('js_app_asset'))
{
    /**
     * @param $js_file
     * @return string
     */
    function js_app_asset($js_file)
    {
        return '/assets/js/app/' . $js_file . '.js';
    }
}

if(!function_exists('js_admin_asset'))
{
    /**
     * @param $js_file
     * @return string
     */
    function js_admin_asset($js_file)
    {
        return '/assets/js/admin/' . $js_file . '.js';
    }
}

if(!function_exists('img_asset'))
{
    /**
     * @param $img_file
     * @param $extension
     * @return string
     */
    function img_asset($img_file, $extension = 'png')
    {
        return '/assets/img/' . $img_file . '.' . $extension;
    }
}

if(!function_exists('favicon_img_asset'))
{
    /**
     * @param $favicon
     * @return string
     */
    function favicon_img_asset($favicon)
    {
        return '/assets/img/favicon/' . $favicon . '.png';
    }
}

if(!function_exists('flag_img_asset'))
{
    /**
     * @param $flag
     * @return string
     */
    function flag_img_asset($flag)
    {
        return '/assets/img/flags/' . $flag . '.png';
    }
}