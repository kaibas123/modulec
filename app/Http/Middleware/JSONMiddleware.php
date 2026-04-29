<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JSONMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
//    function for set header to Accept application/json in api path
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is("api/*")) {
            $request->headers->set("Accept", "application/json");
        }

        return $next($request);
    }
}
