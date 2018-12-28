<?php

namespace App\Http\Controllers\App;

use App\Http\Requests\TransactionFilterRequest;
use Exception;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Traits\PaginationTrait;
use App\Traits\LocaleAmountTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Traits\ErrorFlashMessagesTrait;
use App\Http\Requests\CategoryTypeRequest;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    use ErrorFlashMessagesTrait, PaginationTrait, LocaleAmountTrait;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $type = $request->query('type');
        if(!$this->isType($type)) $type = Category::INCOME;

        $categories = collect(); $incomeCategories = collect();
        $transferCategories = collect(); $expenseCategories = collect();
        try
        {
            $categories = Auth::user()->categories;
            $incomeCategories = $categories->where('type', Category::INCOME)->sortByDesc('updated_at');
            $transferCategories = $categories->where('type', Category::TRANSFER)->sortByDesc('updated_at');
            $expenseCategories = $categories->where('type', Category::EXPENSE)->sortByDesc('updated_at');
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return view('app.categories.index', compact('incomeCategories',
            'transferCategories', 'expenseCategories', 'categories', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $name = $request->input('name');
        $type = $request->input('type');
        $icon = $request->input('icon');
        if(!$this->isType($type) || !$this->isIcon($icon) )
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back()->withInput($request->all());
        }
        $this->categoryExist($name);

        try
        {
            $category = Auth::user()->categories()->create([
                'name' => $name,
                'description' => $request->input('description'),
                'icon' => $icon,
                'color' => $request->input('color'),
                'type' => $type,
            ]);

            success_flash_message(trans('auth.success'),
                trans('general.add_successful', ['name' => $name]));

            return redirect($this->showRoute($category));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back()->withInput($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $language
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $language, Category $category)
    {
        $tab = $request->query('tab');
        $begin_date = now(session('timezone'))->startOfDay();
        $end_date = now(session('timezone'))->endOfDay();
        $category->load('transactions');

        if(session()->has('begin_date') && session()->has('end_date'))
        {
            $begin_date = session('begin_date');
            $end_date = session('end_date');
        }
        try
        {
            $begin_date->setTimezone('UTC');
            $end_date->setTimezone('UTC');

            $transactions = $category->transactions
                ->where('created_at', '>=', $begin_date)->where('created_at', '<=', $end_date)
                ->sortByDesc('id')->sortByDesc('created_at')->load('category', 'wallets');

            $begin_date->setTimezone(session('timezone'));
            $end_date->setTimezone(session('timezone'));

            if($category->authorised) return view('app.categories.show', compact('category', 'transactions',
                'begin_date', 'end_date', 'tab'));
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {

            $this->databaseError($exception);
        }

        return back();
    }

    /**
     * @param TransactionFilterRequest $request
     * @param $language
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter(TransactionFilterRequest $request, $language, Category $category)
    {
        try
        {
            session()->flash('begin_date', $this->carbonFormatDate($request->input('begin_date')));
            session()->flash('end_date', $this->carbonFormatDate($request->input('end_date')));
        }
        catch (Exception $exception)
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back()->withInput($request->all());
        }

        return redirect(locale_route('categories.show', [$category]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param $language
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $language, Category $category)
    {
        try
        {
            if($category->authorised) return view('app.categories.edit', compact('category'));
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryTypeRequest $request
     * @param $language
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryTypeRequest $request, $language, Category $category)
    {
        $name = $request->input('name');
        $icon = $request->input('icon');
        if(!$this->isIcon($icon))
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back()->withInput($request->all());
        }
        $this->categoryExist($name, $category->id);

        try
        {
            if($category->authorised)
            {
                $category->update([
                    'name' => $name,
                    'description' => $request->input('description'),
                    'icon' => $icon,
                    'color' => $request->input('color')
                ]);

                success_flash_message(trans('auth.success'),
                    trans('general.update_successful', ['name' => $name]));

                return redirect($this->showRoute($category, 'details'));
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back()->withInput($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $language
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $language, Category $category)
    {
        $type = Category::INCOME;
        try
        {
            if($category->authorised)
            {
                if($category->can_be_deleted)
                {
                    $type = $category->type;
                    $category->delete();
                    info_flash_message(trans('auth.info'),
                        trans('general.delete_successful', ['name' => $category->name]));
                }
                else danger_flash_message(trans('auth.error'), trans('general.c_n_d_category'));

            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect(locale_route('categories.index') . '?type=' . $type);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report(Request $request)
    {
        if($request->query('date') == null) $date_range = 0;
        else $date_range = $request->query('date');
        $type = $request->query('type');

        $types = [Transaction::DAILY, Transaction::WEEKLY, Transaction::MONTHLY, Transaction::YEARLY];
        if(!(is_string($type) && in_array($type, $types)) || !is_numeric($date_range))
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back();
        }

        $begin_date = now(session('timezone'));
        $end_date = now(session('timezone'));
        $current_currency = $this->getCurrency();

        if($type === Transaction::DAILY)
        {
            $begin_date->addDay($date_range)->startOfDay();
            $end_date->addDay($date_range)->endOfDay();
        }
        else if($type === Transaction::WEEKLY)
        {
            $begin_date->addWeek($date_range)->startOfWeek();
            $end_date->addWeek($date_range)->endOfWeek();
        }
        else if($type === Transaction::MONTHLY)
        {
            $begin_date->addMonth($date_range)->startOfMonth();
            $end_date->addMonth($date_range)->endOfMonth();
        }
        else
        {
            $begin_date->addYear($date_range)->startOfYear();
            $end_date->addYear($date_range)->endOfYear();
        }

        $begin_date->setTimezone('UTC');
        $end_date->setTimezone('UTC');

        $transactions = Auth::user()->transactions
            ->where('created_at', '>=', $begin_date)
            ->where('created_at', '<=', $end_date)
            ->sortByDesc('created_at');

        $begin_date->setTimezone(session('timezone'));
        $end_date->setTimezone(session('timezone'));

        $incomes_amount = $this->transactions_category_amount($transactions, Category::INCOME);
        $transfer_amount = $this->transactions_category_amount($transactions, Category::TRANSFER);
        $expenses_amount = $this->transactions_category_amount($transactions, Category::EXPENSE);
        $total = $this->transactions_category_amount($transactions);
        return view('app.reports.categories', compact('incomes_amount',
            'type', 'transfer_amount', 'expenses_amount', 'date_range',
            'current_currency', 'total', 'begin_date', 'end_date'));
    }

    /**
     * Check if the account already exist
     *
     * @param  string $name
     * @param int $id
     * @return void
     */
    private function categoryExist($name, $id = 0)
    {
        if(Auth::user()->categories->where('slug', Auth::user()->id . '-' . str_slug($name))
                ->where('id', '<>', $id)->count() > 0)
        {
            throw ValidationException::withMessages([
                'name' => trans('general.already_exist', ['name' => mb_strtolower($name)]),
            ])->status(423);
        }
    }

    /**
     * @param $type
     * @return bool
     */
    private function isType($type)
    {
        $types = [Category::EXPENSE, Category::TRANSFER, Category::INCOME];
        return is_string($type) && in_array($type, $types);
    }

    /**
     * @param $icon
     * @return bool
     */
    private function isIcon($icon)
    {
        return is_string($icon) && icons()->contains($icon);
    }

    /**
     * @param Collection $transactions
     * @param $type
     * @return string
     */
    private function transactions_category_amount(Collection $transactions, $type = '')
    {
        $currency = $this->getCurrency();
        if($type === '')
        {
            $transactions_amount = $transactions->sum(function (Transaction $transaction) {
                if($transaction->is_stated)
                {
                    if($transaction->category->type === Category::EXPENSE) return - $transaction->amount;
                    else if($transaction->category->type === Category::INCOME) return $transaction->amount;
                    return 0;
                }
                return 0;
            }) / $currency->devaluation;
        }
        else
        {
            $transactions_amount = $transactions->sum(function (Transaction $transaction) use ($type) {
                if($transaction->category->type === $type && $transaction->is_stated)
                    return $transaction->amount;
                return 0;
            }) / $currency->devaluation;
        }
        return $this->formatNumber($transactions_amount);
    }

    /**
     *
     */
    protected function getCurrency()
    {
        return Auth::user()->currencies
            ->where('is_current', true)->first();
    }

    /**
     * @param Category $category
     * @param string $tab
     * @return bool
     */
    private function showRoute(Category $category, $tab = '')
    {
        if($tab === '') return locale_route('categories.show', [$category]);
        else return locale_route('categories.show', [$category]) . '?tab=' . $tab;
    }
}
