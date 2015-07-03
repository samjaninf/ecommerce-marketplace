<?php namespace Koolbeans\Http\Controllers\Admin;

use Carbon\Carbon;
use Koolbeans\Http\Controllers\Controller;
use Koolbeans\Order;
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
            ->with('profitable', $coffeeShop->getMostProfitable())
            ->with('orders', Order::where('created_at', '>', Carbon::now()->subMonth(2))
                                  ->wherePaid(true)
                                  ->orderBy('id', 'desc')
                                  ->get());
    }

    /**
     * @param null $from
     */
    public function reporting($from = null)
    {

        $sales =
            Order::selectRaw('suM(orders.price) as aggregate, order_lines.product_id as product_id, products.name as product_name')
                 ->join('order_lines', function ($join) {
                     $join->on('orders.id', '=', 'order_lines.order_id');
                 })
                 ->join('products', function ($join) {
                     $join->on('order_lines.product_id', '=', 'products.id');
                 })
                 ->where('orders.paid', true);

        if ($from !== null) {
            $from = new Carbon($from);
            $sales->where('orders.created_at', '>=', $from->format('Y-m-d'));
        }

        $sales = $sales->groupBy('product_id')->orderBy('orders.created_at', 'desc')->get();

        return view('admin.reporting', compact('sales'));
    }
}
