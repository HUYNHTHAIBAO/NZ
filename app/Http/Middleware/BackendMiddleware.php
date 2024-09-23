<?php

namespace App\Http\Middleware;

use Closure;

class BackendMiddleware
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
        session_start();
        if (!Auth()->guard('backend')->check()) {
            $_SESSION['KCFINDER']['disabled'] = true;
            return redirect(Route('backend.login'));
        }
        $_SESSION['KCFINDER']['disabled'] = false;
        $_SESSION['KCFINDER']['uploadURL'] = config('constants.upload_dir.url') . '/';
        $_SESSION['KCFINDER']['uploadDir'] = config('constants.upload_dir.root') . '/';

        return $next($request);
    }
}
