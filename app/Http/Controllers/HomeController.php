<?php namespace Koolbeans\Http\Controllers;


use Koolbeans\Http\Requests;
use Koolbeans\Http\Requests\UserRequest;

class HomeController extends Controller
{

    /**
     * Show the application dashboard to the user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
 
        $drinks = [
          'Latte',
          'Cappucino',
          'Espreso',
          'Mocha',
          'Ice Coffee',
          'Frappucino',
          'Americano',
          'Macchiato',
          'Flat White',
          'Caramel Macchiato',
          'Cafe Au Lait'
        ];

        $user = current_user();

        $message = [];
        if ($user->isOwner()) {
            if ($user->hasValidCoffeeShop()) {
                $images = $user->coffee_shop->gallery()->orderBy('position')->limit(3)->get();

                return view('dashboard', [
                    'coffeeShop' => $user->coffee_shop,
                    'images'     => $images,
                    'firstImage' => $images->isEmpty() ? null : $images[0]->image,
                    'orders'     => $user->coffee_shop->orders()
                                                      ->where('paid', true)
                                                      ->where('status', '!=', 'collected')
                                                      ->orderBy('id', 'desc')
                                                      ->get(),
                    'mostBought' => \DB::select(<<<RAW
SELECT COUNT(*) as aggregate, product_id
FROM order_lines JOIN orders ON orders.id = order_lines.order_id
WHERE coffee_shop_id = {$user->coffee_shop->id}
GROUP BY product_id
ORDER BY aggregate DESC
LIMIT 15
RAW
                    ),
                ]);
            }

            $message = $user->coffee_shop->status === 'requested' ? [
                'info' => 'Your shop has not been accepted yet. ' .
                          'In the meantime, you can still look at the shops close to you ' .
                          'and look for your concurrence!',
            ] : [
                'alert' => 'Your shop has been denied. Please check the comment on <a href="' .
                           route('coffee-shop.apply') . '">this page</a>, and feel free to apply again!',
            ];
        }

        $orders = current_user()
            ->orders()
            ->with('order_lines.product')
            ->with('coffee_shop')
            ->wherePaid(true)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('home', compact('orders'))->with('messages', $message)->with('drinks', $drinks)->with('favourite', $user->favourite_products)->with('user', $user);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function reporting()
    {
        $id         = current_user()->id;
        $sql        = <<<SQL
SELECT DATE_FORMAT(orders.created_at, '%M %Y') as actual_date, SUM(price) as price
FROM coffee_shops
JOIN orders
  ON orders.coffee_shop_id = coffee_shops.id
WHERE coffee_shops.user_id = $id
AND paid = true
GROUP BY actual_date
ORDER BY actual_date DESC
SQL;
        $reporting  = \DB::connection()->select($sql);
        $coffeeShop = current_user()->coffee_shop;
        $images     = $coffeeShop->gallery()->orderBy('position')->limit(3)->get();

        return view('reporting', compact('reporting', 'coffeeShop'))->with([
            'images'     => $images,
            'firstImage' => $images->isEmpty() ? null : $images[0]->image,
        ]);
    }

    public function store(UserRequest $request) {
        $user = current_user();

        $drinks = [
          'Latte',
          'Cappucino',
          'Espreso',
          'Mocha',
          'Ice Coffee',
          'Frappucino',
          'Americano',
          'Macchiato',
          'Flat White',
          'Caramel Macchiato',
          'Cafe Au Lait'
        ];

        $name = $request->input('name');
        $email = $request->input('email');

        if($email) {
          \DB::table('users')
                      ->where('id', $user->id)
                      ->update(['favourite_products' => $request->input('drink')]);
        }
        if($name) {
          \DB::table('users')
                      ->where('id', $user->id)
                      ->update(['name' => $name]);
        }

        $favourite = \DB::table('users')
                    ->where('id', $user->id)
                    ->select('favourite_products')
                    ->get();

        if(isset($favourite)) {
          $favourite = $favourite[0]->favourite_products;
        } else {
          $favourite = '1';
        }

        $user = current_user();

        $orders = current_user()
            ->orders()
            ->with('order_lines.product')
            ->with('coffee_shop')
            ->wherePaid(true)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('home', compact('orders'))->with('drinks', $drinks)->with('favourite', $favourite)->with('name', $name)->with('email', $email);
    }


}
