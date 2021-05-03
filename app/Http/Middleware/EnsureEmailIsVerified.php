<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified as MiddlewareEnsureEmailIsVerified;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified extends MiddlewareEnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {   
        $user = User::where('email', Auth()->user()->email)->first() ?? auth()->user();

        if (!$user || !($user instanceof MustVerifyEmail && $user->hasVerifiedEmail())) {
            return abort(403, 'Your email address is not verified.');
        }

        return $next($request);
    }
}
