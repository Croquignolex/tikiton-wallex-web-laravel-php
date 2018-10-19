<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Utils\PaginationTools;

trait PaginationTrait
{
    private $paginationTools;

    /**
     * @param Request $request
     * @param $items
     * @param int $itemsPerPage
     * @param int $itemsBeforeAndAfter
     */
    private function paginate(Request $request, $items, $itemsPerPage = 6, $itemsBeforeAndAfter = 2)
    {
        $this->paginationTools = new PaginationTools();
        $this->paginationTools->nextPage = 0;
        $this->paginationTools->previousPage = 0;
        $this->paginationTools->url = $request->fullUrl();

        $this->paginationTools->itemsPerPage = $itemsPerPage;
        $this->paginationTools->itemsNumber = $items->count();
        $this->paginationTools->itemsBeforeAndAfter = $itemsBeforeAndAfter;
        $this->paginationTools->pagesNumber = ceil($this->paginationTools->itemsNumber / $this->paginationTools->itemsPerPage);

        //--user page
        $this->paginationTools->currentPage = is_numeric($request->query('page')) ? $request->query('page') : 1;

        //--check that the page is in the range
        if($this->paginationTools->currentPage < 0) $this->paginationTools->currentPage = 1;
        else if ($this->paginationTools->currentPage > $this->paginationTools->pagesNumber) $this->paginationTools->currentPage = $this->paginationTools->pagesNumber;

        $this->paginationTools->displayItems = $items->forPage($this->paginationTools->currentPage, $this->paginationTools->itemsPerPage);
        $this->paginationTools->displayItems->all();

        if($this->paginationTools->currentPage > 1)
            $this->paginationTools->previousPage = $this->paginationTools->currentPage - 1;

        if($this->paginationTools->currentPage != $this->paginationTools->pagesNumber)
            $this->paginationTools->nextPage = $this->paginationTools->currentPage + 1;
    }
}