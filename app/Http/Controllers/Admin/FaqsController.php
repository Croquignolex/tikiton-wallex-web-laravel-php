<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Faq;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\UserRegisterMail;
use App\Traits\PaginationTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use App\Traits\ErrorFlashMessagesTrait;

class FaqsController extends Controller
{
    use ErrorFlashMessagesTrait, PaginationTrait;

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $faqs = collect();
        try
        {
            $faqs = Faq::all()->sortByDesc('updated_at');
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        $this->paginate($request, $faqs, 10, 3);
        $paginationTools = $this->paginationTools;
        return view('admin.faqs.index', compact('paginationTools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        try
        {
            $user = Role::where('type', Role::USER)->first()->users()->create([
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'last_name' => $request->input('last_name'),
                'first_name' => $request->input('first_name')
            ]);

            try
            {
                Mail::to($user->email)->send(new UserRegisterMail($user));
                success_flash_message(trans('auth.success'), trans('auth.registration_message'));
            }
            catch (Exception $exception)
            {
                $user->delete();
                $this->mailError($exception);
            }
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Faq $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Faq $faq)
    {
        try
        {
            if($faq->authorised) return view('admin.faqs.show', compact('faq'));
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back();
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Request $request, User $user)
    {
        try
        {
            if($user->authorised)
            {
                $user->update(['is_confirmed' => false]);
                info_flash_message(trans('auth.info'),
                    'L\'utilisateur ' . $user->format_full_name . ' est bloqué');
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect($this->showRoute($user));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Request $request, User $user)
    {
        try
        {
            if($user->authorised)
            {
                $user->update(['is_confirmed' => true]);
                info_flash_message(trans('auth.info'),
                    'L\'utilisateur ' . $user->format_full_name . ' est confirmé');
                $this->userFactoryData($user);
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect($this->showRoute($user));
    }
}
