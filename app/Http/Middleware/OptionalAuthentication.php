<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate;

class OptionalAuthentication extends Authenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch(AuthenticationException $e) {
            // dont do anything
        }

        return $next($request);
    }
}
