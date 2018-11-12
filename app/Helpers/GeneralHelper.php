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
                                $icon = 'fa fa-info-circle', $enter = 'flipInX',
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
                                $icon = 'fa fa-exclamation-triangle', $enter = 'flash',
                                $exit = 'fadeOut')
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
        session()->flash('popup.icon', $icon);
        session()->flash('popup.type', $type);
        session()->flash('popup.title', $title);
        session()->flash('popup.delay', $delay);
        session()->flash('popup.message', $message);
        session()->flash('popup.animate.exit', $exit);
        session()->flash('popup.animate.enter', $enter);
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

if(!function_exists('icons'))
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function icons()
    {
        return collect([
            'bank', 'bell', 'bicycle', 'book', 'briefcase', 'calculator',
            'coffee', 'credit-card', 'diamond', 'envelope', 'feed', 'flash',
            'folder-open', 'gamepad', 'gift', 'group', 'hotel', 'legal',
            'mortar-board', 'map-marker', 'phone', 'pie-chart', 'plus-circle',
            'trash', 'truck', 'video-camera', 'wifi', 'soccer-ball-o',
            'print', 'motorcycle', 'line-chart', 'heart', 'glass', 'flask',
            'female', 'cubes', 'car', 'bookmark', 'bath', 'balance-scale', 'cogs',
            'comments', 'download', 'exchange', 'filter', 'globe', 'laptop',
            'male', 'money', 'plug', 'road', 'shopping-cart', 'tv', 'wrench',
            'umbrella', 'taxi', 'shower', 'star', 'music', 'at', 'archive',
            'rocket', 'ambulance', 'plane', 'ship', 'subway', 'mars', 'venus',
            'paypal', 'cc-visa', 'dollar', 'eur', 'btc', 'compress', 'expand',
            'facebook', 'firefox', 'github-alt', 'html5', 'joomla', 'amazon',
            'internet-explorer', 'windows', 'twitter', 'telegram', 'opera',
            'bluetooth', 'apple', 'git', 'skype', 'whatsapp', 'youtube-play',
            'linkedin', 'android', 'medkit', 'plus-square', 'wheelchair-alt',
            'stethoscope', 'user-md', 'wheelchair', 'wikipedia-w'
        ]);
    }
}