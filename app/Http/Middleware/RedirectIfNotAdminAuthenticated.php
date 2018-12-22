<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) return redirect(route('admin.login'));
        else
        {
            if(Auth::user()->role->type === Role::USER)
                return redirect(locale_route('dashboard.index'));
        }

        return $next($request);
    }
}
