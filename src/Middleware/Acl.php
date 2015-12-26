<?php
namespace KjmTrue\Acl\Middleware;

use Closure;
use Auth;

class Acl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeName = $request->route()->getName();

        if (Auth::check() && Auth::user()->can($routeName)) {
            return $next($request);
        }

        if ($request->isJson() || $request->wantsJson()) {
            return response()->json([
                'error' => [
                    'status_code' => 401,
                    'code'        => 'INSUFFICIENT_PERMISSIONS',
                    'description' => trans('errors.401'),
                ],
            ], 401);
        }

        return abort(401, trans('errors.401'));
    }
}
