<?php namespace Koolbeans\Http\Controllers;

use Koolbeans\Http\Requests\RequestCoffeeShopRequest;
use Koolbeans\Repositories\CoffeeShopRepository;
use Laravel\Cashier\StripeGateway;

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
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShop
     *
     * @return \Illuminate\View\View
     */
    public function index(CoffeeShopRepository $coffeeShop)
    {
        $user = current_user();
        if ($user->isOwner()) {
            return view('home', ['user' => $user]);
        }

        return view('contact', ['coffeeShop' => $coffeeShop->newInstance()]);
    }

    /**
     * @param \Koolbeans\Repositories\CoffeeShopRepository      $coffeeShop
     * @param \Koolbeans\Http\Requests\RequestCoffeeShopRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contact(CoffeeShopRepository $coffeeShop, RequestCoffeeShopRequest $request)
    {
        $instance = $coffeeShop->newInstance($request->all());
        $instance->user()->associate(current_user());
        $instance->save();

        return redirect('/')->with('messages',
            ['info' => 'Your request has been sent trough! We shall contact you back very soon, stay close!']);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function stripe()
    {
        return view('stripe');
    }

    public function stripeHandler()
    {
        $user = current_user();
        if ( ! $user->hasStripeId()) {
            $gateway = new StripeGateway($user);
            $customer = $gateway->createStripeCustomer(\Input::get('stripeToken'));
            $user->setStripeId($customer->id);
            $user->save();
        }

        $user->transactions()->create(['amount' => 593]);

        return view('stripe')->with('messages', ['info' => 'Payment successful']);
    }

    public function stripeCharge()
    {
        $user   = current_user();
        $amount = $user->transactions()->sum('amount');

        $user->charge($amount, ['currency' => 'gbp']);

        $user->transactions()->delete();

        return view('stripe')->with('messages', ['info' => 'User charged!']);
    }
}
