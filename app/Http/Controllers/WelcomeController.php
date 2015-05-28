<?php namespace Koolbeans\Http\Controllers;

use Illuminate\Http\Request;
use Koolbeans\Repositories\CoffeeShopRepository;

class WelcomeController extends Controller
{

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShops
     *
     * @return \Illuminate\View\View
     */
    public function index(CoffeeShopRepository $coffeeShops)
    {
        $featured    = array_fill(0, 7, null);
        $coffeeShops = $coffeeShops->getFeatured();
        foreach ($coffeeShops as $coffeeShop) {
            $featured[ $coffeeShop->featured - 1 ] = $coffeeShop;
        }

        return view('welcome')->with('featuredShops', $featured);
    }

    /**
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShops
     * @param null                                         $query
     * @param int                                          $page
     *
     * @return \Illuminate\View\View
     */
    public function search(CoffeeShopRepository $coffeeShops, $query = null, $page = 1)
    {
        if ($this->request->method() === 'POST') {
            $query = $this->request->get('query');
        }

        return view('search.results');
    }
}
