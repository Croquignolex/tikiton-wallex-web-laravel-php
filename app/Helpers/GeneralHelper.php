<?php

if(!function_exists('locale_route'))
{
    /**
     * @param $name
     * @param array|null $parameters
     * @return string
     */
    function locale_route($name, array $parameters = null)
    {
        //--Get current language
        $language = Illuminate\Support\Facades\App::getLocale();

        //--Return the correct rout with local
        return $parameters == null ?
            route($name, compact('language')) :
            route($name, array_collapse([
                compact('language'),
                $parameters
            ]));
    }
}

if(!function_exists('currency'))
{
    /**
     * @param $amount
     * @param string $symbol
     * @return string
     * @internal param $name
     */
    function currency($amount, $symbol = 'C$')
    {
        if(Illuminate\Support\Facades\App::getLocale() === 'fr')
            return $amount . $symbol;
        else if (Illuminate\Support\Facades\App::getLocale() === 'en')
            return $symbol . $amount;
        else return $amount . $symbol;
    }
}

if(!function_exists('info_flash_message'))
{
    /**
     * @param $title
     * @param $message
     * @param string $icon
     * @param string $enter
     * @param string $exit
     * @param int $delay
     */
    function info_flash_message($title, $message,  $delay = 8000,
                                $icon = 'fa fa-info-circle', $enter = 'flipInY',
                                $exit = 'flipOutX')
    {
        flash_message($title, $message, $icon,
            'info', $enter, $exit, $delay);
    }
}

if(!function_exists('success_flash_message'))
{
    /**
     * @param $title
     * @param $message
     * @param string $icon
     * @param string $enter
     * @param string $exit
     * @param int $delay
     */
    function success_flash_message($title, $message, $delay = 5000,
                                   $icon = 'fa fa-check', $enter = 'lightSpeedIn',
                                   $exit = 'lightSpeedOut')
    {
        flash_message($title, $message, $icon,
            'success', $enter, $exit, $delay);
    }
}

if(!function_exists('warning_flash_message'))
{
    /**
     * @param $title
     * @param $message
     * @param string $icon
     * @param string $enter
     * @param string $exit
     * @param int $delay
     */
    function warning_flash_message($title, $message,  $delay = 8000,
                                $icon = 'fa fa-exclamation-triangle', $enter = 'flipInY',
                                $exit = 'flipOutX')
    {
        flash_message($title, $message, $icon,
            'warning', $enter, $exit, $delay);
    }
}

if(!function_exists('danger_flash_message'))
{
    /**
     * @param $title
     * @param $message
     * @param string $icon
     * @param string $enter
     * @param string $exit
     * @param int $delay
     */
    function danger_flash_message($title, $message, $delay = 10000,
                                  $icon = 'fa fa-times', $enter = 'bounceIn',
                                  $exit = 'bounceOut')
    {
        flash_message($title, $message, $icon,
            'danger', $enter, $exit, $delay);
    }
}

if(!function_exists('flash_message'))
{
    /**
     * @param $title
     * @param $message
     * @param string $type
     * @param string $icon
     * @param string $enter
     * @param string $exit
     * @param int $delay
     */
    function flash_message($title, $message, $icon, $type,
                           $enter, $exit, $delay)
    {
        session()->flash('notification.icon', $icon);
        session()->flash('notification.type', $type);
        session()->flash('notification.title', $title);
        session()->flash('notification.delay', $delay);
        session()->flash('notification.message', $message);
        session()->flash('notification.animate.exit', $exit);
        session()->flash('notification.animate.enter', $enter);
    }
}

if(!function_exists('text_format'))
{
    /**
     * @param $text
     * @param $maxCharacters
     * @return string
     */
    function text_format($text, $maxCharacters)
    {
        if(strlen($text) <= $maxCharacters)
            return $text;
        else
            return substr($text, 0, $maxCharacters) . '...';
    }
}

if(!function_exists('get_index_in_collection'))
{
    /**
     * @param \Illuminate\Support\Collection $collection
     * @param $element
     * @return int
     */
    function get_index_in_collection(\Illuminate\Support\Collection $collection, $element)
    {
        $i = 0;

        foreach ($collection as $_element)
        {
            if($_element == $element) break;
            $i++;
        }

        return $i;
    }
}

if(!function_exists('get_element_in_collection'))
{
    /**
     * @param \Illuminate\Support\Collection $collection
     * @param $index
     * @return string
     */
    function get_element_in_collection(\Illuminate\Support\Collection $collection, $index)
    {
        $elements_number = $collection->count();

        if($index <= 0) return $collection[0];
        elseif($index >= $elements_number) return $collection[$elements_number - 1];
        else return $collection[$index];
    }
}