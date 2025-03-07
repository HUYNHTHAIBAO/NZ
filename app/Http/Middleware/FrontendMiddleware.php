<?php

namespace App\Http\Middleware;

use Closure;

class FrontendMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth()->guard('web')->check()) {
            return redirect(Route('frontend.user.login'));
        }

        return $next($request);
    }
}
