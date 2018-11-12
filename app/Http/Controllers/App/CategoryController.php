<?php

namespace App\Http\Controllers\App;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Traits\ErrorFlashMessagesTrait;
use App\Http\Requests\CategoryTypeRequest;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    use ErrorFlashMessagesTrait, PaginationTrait;

    /**
     * AccountController constructor.
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
        if(!$type) $type = Category::INCOME;

        $categories = null; $incomeCategories = null;
        $transferCategories = null; $expenseCategories = null;
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
        if(!$this->isType($request->input('type')) || !$this->isIcon($request->input('icon')) )
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back();
        }
        $this->categoryExist($request->input('name'));

        try
        {
            Auth::user()->categories()->create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'icon' => $request->input('icon'),
                'color' => $request->input('color'),
                'type' => $request->input('type'),
            ]);

            success_flash_message(trans('auth.success'),
                trans('general.add_successful', ['name' => $request->input('name')]));

            return redirect($this->redirectTo($request->input('type')));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back();
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
        if(!$this->isIcon($request->input('icon')) )
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back();
        }
        $this->categoryExist($request->input('name'), $category->id);

        try
        {
            $category->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'icon' => $request->input('icon'),
                'color' => $request->input('color')
            ]);

            success_flash_message(trans('auth.success'),
                trans('general.update_successful', ['name' => $request->input('name')]));

            return redirect($this->redirectTo($category->type));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back();
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
                else danger_flash_message(trans('auth.error'), trans('general.c_n_d_group'));

            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect($this->redirectTo($type));
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
        return is_numeric($type) && in_array($type, $types);
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
     * @return bool
     */
    private function redirectTo($parameter)
    {
        return locale_route('categories.index') . '?type=' . $parameter;
    }
}
