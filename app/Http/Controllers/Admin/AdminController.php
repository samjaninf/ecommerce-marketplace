<?php namespace Koolbeans\Http\Controllers\Admin;

use Koolbeans\Http\Controllers\Controller;
use Koolbeans\Repositories\CoffeeShopRepository;

class AdminController extends Controller
{
    /**
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShop
     *
     * @return \Illuminate\View\View
     */
    public function index(CoffeeShopRepository $coffeeShop)
    {
        return view('admin.dashboard')
            ->with('applications', $coffeeShop->getApplications())
            ->with('profitable', $coffeeShop->getMostProfitable());
    }
}
