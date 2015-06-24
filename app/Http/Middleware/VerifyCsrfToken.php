<?php namespace Koolbeans\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Support\Str;

class VerifyCsrfToken extends BaseVerifier
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle($request, Closure $next)
    {
        if ($request->ajax() || Str::contains($request->getUri(), 'webhooks')) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }

}
