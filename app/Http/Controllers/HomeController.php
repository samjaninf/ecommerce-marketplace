<?php namespace Koolbeans\Http\Controllers;

class HomeController extends Controller
{

    /**
     * Show the application dashboard to the user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
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

        return view('home')->with('messages', $message);
    }
}
