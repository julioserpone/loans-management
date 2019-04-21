<?php

namespace App\Http\Middleware;

use Closure;

class HasRole
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
        $roles = $this->getRequiredRoleForRoute($request->route());

        if ($request->user() !== null && $request->user()->hasRole($roles)) {
            return $next($request);
        } else {
            \Session::put('message', trans('user.insufficient_role'));
            \Session::put('messageClass', 'error');
            \Session::put('messageIcon', 'glyphicon glyphicon-remove-circle');
            \Session::put('messageTitle', trans('globals.error_alert_title'));
            \Session::save();
            \Redirect::to('auth/login')->send();
        }
    }

    /**
     * gets the route role
     * @param  string/array $route route information
     * @return bool
     */
    private function getRequiredRoleForRoute($route)
    {
        $actions = $route->getAction();
        return isset($actions['roles']) ? $actions['roles'] : null;
    }
}
