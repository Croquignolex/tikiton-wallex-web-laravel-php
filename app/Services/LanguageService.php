<?php

namespace App\Services;

use Illuminate\Support\Facades\App;

class LanguageService
{
    /**
     * @return array
     */
    public function getLanguages()
    {
        return config('app.locales');
    }

    /**
     * @return string
     */
    public function getCurrentLanguage()
    {
        return App::getLocale();
    }

    /**
     * @param $language
     * @return mixed|string
     */
    public function getUrl($language)
    {
        $fullUrl = url()->full();


        if(in_array($language, $this->getLanguages()))
        {
            foreach ($this->getLanguages() as $lang)
            {
                if(str_contains($fullUrl, $lang))
                    return str_replace($lang, $language, $fullUrl);
            }
        }

        $url = config('app.url');
        return str_replace_first($url, $url . '/' . $language, $fullUrl);
    }

    /**
     * @param $language
     * @return string
     */
    public function getLanguageFullName($language)
    {
        if(in_array($language, $this->getLanguages())) return trans('language.' . $language);
        else return 'language.unknown';
    }

    /**
     * @param $language
     * @return bool
     */
    public function isActiveLanguage($language)
    {
        return $this->getCurrentLanguage() == $language;
    }

    /**
     * @param $language
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function getTitle($language)
    {
        $lang = mb_strtolower($this->getLanguageFullName($language));

        return $this->isActiveLanguage($language)
            ? trans('general.page_already_in', ['language' => $lang])
            : trans('general.translate_in', ['language' => $lang]);
    }
}