<?php

namespace App\Http\Middleware;

use App\Http\Requests\LogRequest;
use Closure;

class AllJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param LogRequest $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(LogRequest $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}


