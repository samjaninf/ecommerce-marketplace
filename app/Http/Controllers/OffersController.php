<?php

namespace Koolbeans\Http\Controllers;

use Koolbeans\Offer;

class OffersController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $coffeeShop = current_user()->coffee_shop;
        $products = $coffeeShop->products;
        $offer = new Offer;

        return view('offers.create', compact('coffeeShop', 'products', 'offer'));
    }
}
