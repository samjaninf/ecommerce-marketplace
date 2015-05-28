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

    /**
     * @param int    $id
     * @param string $status
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function review($id, $status)
    {
        $coffeeShop         = $this->coffeeShop->find($id);
        $coffeeShop->status = $status;
        $coffeeShop->save();

        if ($status === 'requested') {
            return redirect()
                ->back()
                ->with('messages', ['info' => "Coffee shop put on hold. You can safely review it."]);
        }

        $next = $this->coffeeShop->findNextApplication($coffeeShop);

        if ($next === null) {
            return redirect(route('admin.home'))->with('messages',
                ['info' => "Coffee shop $status!", 'success' => 'You reviewed all applications!']);
        }

        return redirect(route('admin.coffee_shop.show', ['coffee_shop' => $next]))->with('messages',
            ['info' => "Coffee shop $status!"]);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $coffeeShop = $this->coffeeShop->find($id);

        if ($coffeeShop->status === 'requested') {
            list( $previous, $next ) = $this->coffeeShop->findAdjacentApplications($coffeeShop);
        }

        if (empty( $previous )) {
            $previous = $coffeeShop;
        }

        if (empty( $next )) {
            $next = $coffeeShop;
        }

        return view('admin.coffee_shop.show', [
            'coffeeShop' => $coffeeShop,
            'previous'   => $previous,
            'next'       => $next,
        ]);
    }
}
