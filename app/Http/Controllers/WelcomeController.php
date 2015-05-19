<?php namespace Koolbeans\Http\Controllers;

use Koolbeans\Repositories\EloquentCoffeeShopRepository;

class WelcomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @param \Koolbeans\Repositories\EloquentCoffeeShopRepository $coffeeShops
     *
     * @return \Illuminate\View\View
     */
    public function index(EloquentCoffeeShopRepository $coffeeShops)
    {
        $featured    = array_fill(0, 7, null);
        $coffeeShops = $coffeeShops->getFeatured();
        foreach ($coffeeShops as $coffeeShop) {
            $featured[ $coffeeShop->featured - 1 ] = $coffeeShop;
        }

        return view('welcome')->with('featuredShops', $featured);
    }
}
