<?php

namespace App\Services;

class PaginationService
{
    /**
     * @param $url
     * @param $page
     * @return string
     */
    public function getPageUrl($url, $page)
    {
        return $this->pageQueryParameterExist($url) ?
            $this->updatePageQueryParameter($url, $page) :
            $this->AddPageQueryParameter($url, $page);
    }

    /**
     * @param $url
     * @param $page
     * @return string
     */
    private function updatePageQueryParameter($url, $page)
    {
        $updatedQueryString = [];
        $queryStringTab = explode('&', $this->getQueryString($url));

        foreach ($queryStringTab as $item)
        {
            $temp = explode('=', $item);
            if(count($temp) >= 2) if($temp[0] === 'page') $temp[1] = $page;
            elseif(count($temp) === 1) if ($temp[0] === 'page') $temp[] = $page;
            $updatedQueryString[] = implode('=', $temp);
        }

        return $this->getBaseUrl($url) . '?' . implode('&', $updatedQueryString);
    }

    /**
     * @param $url
     * @param $page
     * @return string
     */
    private function AddPageQueryParameter($url, $page)
    {
        $queryString = $this->getQueryString($url);

        $updatedQueryString = ($queryString === null) ?
            'page' . '=' . $page :
            $queryString . '&' . 'page' . '=' . $page;

        return  $this->getBaseUrl($url) . '?' . $updatedQueryString;
    }

    /**
     * @param $url
     * @return bool
     */
    private function pageQueryParameterExist($url)
    {
        $queryString = $this->getQueryString($url);
        $pageExist = false;

        if($queryString !== null)
        {
            $queryStringTab = explode('&', $queryString);
            if(count($queryStringTab) >= 1)
            {
                foreach ($queryStringTab as $item)
                {
                    $temp = explode('=', $item);
                    if(count($temp) >= 2) if($temp[0] === 'page') $pageExist = true;
                    elseif (count($temp) === 1) if($temp[0] === 'page') $pageExist = true;
                }
            }
        }

        return $pageExist;
    }

    /**
     * @param $url
     * @return null
     */
    private function getBaseUrl($url)
    {
        $urlTab = explode('?', $url);
        return (count($urlTab) >= 1) ? $urlTab[0] : null;
    }

    /**
     * @param $url
     * @return null
     */
    private function getQueryString($url)
    {
        $urlTab = explode('?', $url);
        return (count($urlTab) >= 2) ? $urlTab[1] : null;
    }
}