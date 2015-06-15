<?php namespace Koolbeans\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Koolbeans\User;

class IsCoffeeShopOwner
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->route()->getParameter('coffee_shop');

        if ( ! $this->getUser()->isOwner() || ( $id !== null && $this->getUser()->coffee_shop->id != (int) $id )) {
            return redirect('/');
        }

        return $next($request);
    }

    /**
     * @return User
     */
    private function getUser()
    {
        return $this->auth->user();
    }
}
