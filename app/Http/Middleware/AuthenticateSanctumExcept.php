<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateSanctumExcept extends Middleware
{
    protected $except = [];

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }

    protected function authenticate($request, array $guards)
    {
        try {
            parent::authenticate($request, $guards);
        } catch (AuthenticationException $exception) {
            if ($this->shouldReturnJson($request)) {
                throw $exception;
            }

            $this->unauthenticated($request, $guards);
        }
    }

    protected function shouldReturnJson($request)
    {
        return $request->expectsJson() || $request->isJson();
    }

    protected function unauthenticated($request, array $guards)
    {
        if ($this->shouldReturnJson($request)) {
            throw new AuthenticationException('Unauthenticated.');
        }

        parent::unauthenticated($request, $guards);
    }
}
