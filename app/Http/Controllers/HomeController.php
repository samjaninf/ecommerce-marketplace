<?php namespace Koolbeans\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\View\View;
use Koolbeans\User;

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
     * @return View
     */
    public function index(Guard $auth)
    {
        /** @var User $user */
        $user = $auth->user();

        if ($user->isOwner()) {
            return view('home', $user);
        }

        return view('contact');
    }
}
