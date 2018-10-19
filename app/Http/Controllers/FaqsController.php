<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;
use App\Traits\ErrorFlashMessagesTrait;

class FaqsController extends Controller
{
    use ErrorFlashMessagesTrait, PaginationTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $faqs = null;
        try
        {
            $faqs = Faq::where('is_visible', true)->get();
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        $this->paginate($request, $faqs);
        $paginationTools = $this->paginationTools;

        return view('faqs', compact('faqs', 'paginationTools'));
    }
}
