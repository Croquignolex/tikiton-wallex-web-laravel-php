<?php

if(!function_exists('page_title'))
{
    /**
     * @param $page
     * @return string
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

if(!function_exists('seo_keywords'))
{
    /**
     * @return string
     */
    function seo_keywords()
    {
         return 'wallex,argent,money,dépense,expense,gain,income,' .
             'transfert,transfer,transaction,compte,account,dévise,currency,revenue';
    }
}

if(!function_exists('seo_description'))
{
    /**
     * @return string
     */
    function seo_description()
    {
        return 'Wallex est votre porte feuille electronique, '.
            'qui vous permet de gerer de manière éfficace vos dépenses et gains.';
    }
}

if(!function_exists('about_pages'))
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function about_pages()
    {
        return collect(['about']);
    }
}

if(!function_exists('contact_pages'))
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function contact_pages()
    {
        return collect(['contact']);
    }
}

if(!function_exists('faqs_pages'))
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function faqs_pages()
    {
        return collect(['faqs']);
    }
}

if(!function_exists('app_dashboard_pages'))
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function app_dashboard_pages()
    {
        return collect(['dashboard']);
    }
}

if(!function_exists('app_wallet_pages'))
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function app_wallet_pages()
    {
        return collect(['wallets.index', 'wallets.create',
            'wallets.edit', 'wallets.show']);
    }
}

if(!function_exists('app_category_pages'))
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function app_category_pages()
    {
        return collect(['categories.index', 'categories.create',
            'categories.edit']);
    }
}

if(!function_exists('app_transaction_pages'))
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function app_transaction_pages()
    {
        return collect(['transactions.index', 'transactions.create',
            'transactions.edit', 'transactions.show', 'transactions.filter']);
    }
}

if(!function_exists('app_currency_pages'))
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function app_currency_pages()
    {
        return collect(['currencies.index', 'currencies.create',
            'currencies.edit', 'currencies.show', 'currencies.wallets.create']);
    }
}

if(!function_exists('app_setting_pages'))
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function app_setting_pages()
    {
        return collect(['settings.index', 'settings.create',
            'settings.edit', 'settings.show']);
    }
}

if(!function_exists('app_user_pages'))
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function app_user_pages()
    {
        return collect();
    }
}

