<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddContentRange
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
        $response = $next($request);
        $size = count(json_decode($response->getContent()));
        $response->header('Content-Range',"posts 0-".$size."/".$size);
        $response->header('Access-Control-Expose-Headers','Content-Range');
        return $response;
    }
}
