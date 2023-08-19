<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Link;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isActiveDownloadLink
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $book = Link::whereToken($request->token)->whereActive(true)->first();

        if (!$book)  abort(403, 'link has been expired');
        return $next($request);;
    }
}
