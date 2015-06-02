<?php namespace Koolbeans\Http\Controllers;

use Koolbeans\Http\Requests;
use Koolbeans\Http\Requests\ApplicationCoffeeShopRequest;
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

    /**
     * @return \Illuminate\View\View
     */
    public function apply()
    {
        if (current_user()->isOwner()) {
            return redirect('home');
        }

        return view('coffee_shop.apply', ['coffeeShop' => $this->coffeeShop->newInstance()]);
    }

    /**
     * @param \Koolbeans\Http\Requests\ApplicationCoffeeShopRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeApplication(ApplicationCoffeeShopRequest $request)
    {
        $shop = $this->coffeeShop->newInstance($request->all());
        $shop->user()->associate(current_user());
        $shop->save();

        return redirect(route('home'))->with('messages',
            ['success' => 'Your request has been sent trough! We shall contact you back very soon, stay close!']);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $coffeeShop = $this->coffeeShop->find($id);
        $bestReview = $coffeeShop->getBestReview();

        return view('coffee_shop.show', compact('coffeeShop', 'bestReview'));
    }
}
