<?php

namespace Koolbeans\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Koolbeans\CoffeeShop;

class CoffeeShopIsOpenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('pickup_time')) {
            $time = new Carbon($request->input('pickup_time') . ':00');
        } elseif ($request->has('time')) {
            $time = new Carbon($request->input('time') . ':00');
        } else {
            $time = Carbon::now();
        }

        if ( ! CoffeeShop::find($request->route("coffee_shop"))->isOpen($time)) {
            return redirect()->back()->with('messages', ['danger' => "The coffee shop is not opened at that time"]);
        }

        return $next($request);
    }
}
