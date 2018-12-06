<?php

namespace App\Http\Middleware;

use Closure;

class ComingSoonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('coming.soon'))
        {
            if(session('coming.soon') === 'ok')
                return $next($request);
        }

        return redirect('/coming');
    }
}
