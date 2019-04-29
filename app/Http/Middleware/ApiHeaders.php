<?php

namespace App\Http\Middleware;

use Closure;


/**
 * Class Authenticate
 * @package App\Http\Middleware
 */
class ApiHeaders
{

    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
