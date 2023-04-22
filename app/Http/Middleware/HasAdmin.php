<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Session;

class HasAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = session()->get("user");

        if (session()->has("user")) {
            // check if the user has permission to this modules
            $modules = collect($user->module);
            $modules->push(['moduleName' => 'Logout']); // always add logout function

            $routes = \Str::of(\Route::currentRouteName())->explode('.')[0];
            $unslug = \Str::title(str_replace('-', ' ', $routes));
            $module = $modules->contains('moduleName', $unslug);

            if (!$module)
                return \Redirect::to('/')->with('error', 'You have no permission.');

            return $next($request);
        }

        return redirect('login');
    }
}
