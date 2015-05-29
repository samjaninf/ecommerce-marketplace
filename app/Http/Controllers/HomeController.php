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
                return view('dashboard', ['coffeeShop' => $user->coffee_shop]);
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
