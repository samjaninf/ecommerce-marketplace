<?php namespace Koolbeans\Http\Controllers;

use Illuminate\Session\SessionManager;

class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @param \Illuminate\Session\SessionManager $session
     *
     * @return \Illuminate\View\View
     */
    public function index(SessionManager $session)
    {
        $user = current_user();

        if ($user->isOwner()) {
            if ($user->coffee_shop->status === 'requested') {
                return view('home', [
                    'messages' => [
                        'info' => 'Your shop has not been accepted yet. ' .
                                  'In the meantime, you can still look at the shops close to you ' .
                                  'and look for your concurrence!',
                    ],
                ]);
            }

            if ($user->coffee_shop->status === 'denied') {
                return redirect(route('coffee_shop.apply'))->with('messages', [
                    'alert' => 'Your shop has been denied. ' .
                               'Please check the comment below to know why, and feel free to apply again!',
                ]);
            }

            return view('dashboard', ['coffeeShop' => $user->coffee_shop]);
        }

        return view('home');
    }
}
