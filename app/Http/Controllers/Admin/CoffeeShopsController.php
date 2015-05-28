<?php namespace Koolbeans\Http\Controllers\Admin;

use Koolbeans\Http\Controllers\Controller;
use Koolbeans\Repositories\CoffeeShopRepository;

class CoffeeShopsController extends Controller
{
    /**
     * @var \Koolbeans\Repositories\CoffeeShopRepository
     */
    private $coffeeShop;

    /**
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShop
     */
    public function __construct(CoffeeShopRepository $coffeeShop)
    {
        $this->coffeeShop = $coffeeShop;
    }

    public function index()
    {
    }
}
