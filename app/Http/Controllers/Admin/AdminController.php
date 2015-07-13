<?php namespace Koolbeans\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Koolbeans\Http\Controllers\Controller;
use Koolbeans\Order;
use Koolbeans\Repositories\CoffeeShopRepository;
use Koolbeans\User;

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
     * @return \Illuminate\View\View|\Response
     */
    public function lastSales()
    {
        return view('admin.sales', [
            'orders' => Order::where('created_at', '>', Carbon::now()->subMonth(2))
                             ->wherePaid(true)
                             ->orderBy('id', 'desc')
                             ->get(),
        ]);
    }

    /**
     * @return \Illuminate\View\View|\Response
     */
    public function users()
    {

        $sql = User::select(\DB::raw('name, points, email, sum(ifnull(price,0)) as agr'))
                   ->leftJoin('orders', function (JoinClause $join) {
                       $join->on('orders.user_id', '=', 'users.id')->on('orders.paid', '=', \DB::raw(true));
                   })
                   ->groupBy('users.id')
                   ->orderBy('agr', 'desc');

        $sql2 = \DB::select(<<<SQL
select name, points, email, sum(ifnull(price,0)) as agr from `users`
left join orders on orders.user_id = users.id and orders.paid = true
group by users.id
order by agr desc
SQL
        );

        return view('admin.users', ['users' => $sql->paginate()]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\View\View|\Response
     */
    public function export(Request $request)
    {
        if (( $type = $request->input('type', null) ) !== null) {
            if ($type == 'customer') {
                $users = User::whereRole('customer')->get();

                $csv = ['Name;Email'];
                foreach ($users as $user) {
                    $csv[] = "$user->name;$user->email";
                }
            } else {
                $users = User::has('coffee_shop')->with('coffee_shop')->get();
                $csv   = ['Name;Coffee Shop;Location;Email;Phone'];
                foreach ($users as $user) {
                    $c     = $user->coffee_shop;
                    $csv[] = "$user->name;$c->name;$c->location;$user->email;$c->phone_number";
                }
            }

            \File::put($path = storage_path("app/export_$type.csv"), implode("\r\n", $csv));

            return response()->download($path);
        }

        return view('admin.export');
    }

    /**
     * @param null $from
     *
     * @return \Illuminate\View\View|\Response
     */
    public function reporting($from = null)
    {
        $sales =
            Order::selectRaw('count(*) as cnt, sum(orders.price) as aggregate, order_lines.product_id as product_id, products.name as product_name')
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

        $sales = $sales->groupBy('product_id')->orderBy('aggregate', 'desc')->get();

        return view('admin.reporting', compact('sales'));
    }
}
