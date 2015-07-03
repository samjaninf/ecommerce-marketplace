<?php namespace Koolbeans\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Koolbeans\Http\Requests;
use Koolbeans\Http\Requests\ApplicationCoffeeShopRequest;
use Koolbeans\Repositories\CoffeeShopRepository;
use Koolbeans\User;

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
        if (\Auth::check() && current_user()->isOwner()) {
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
        if (\Auth::guest()) {
            $user = User::create([
                'name'     => $request->input('name'),
                'email'    => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

            \Auth::login($user);

            \Mail::send('emails.registration', ['user' => current_user()], function (Message $m) use ($request) {
                $m->to($request->input('email'), $request->input('name'))
                  ->subject('Thank you for registering to Koolbeans!');
            });
        } else {
            $user = current_user();
        }

        $shop = $this->coffeeShop->newInstance($request->except(['name', 'email', 'password']));
        $shop->user()->associate($user);
        $shop->save();

        \Mail::send('emails.coffeeshop_registration', ['user' => current_user()], function (Message $m) use ($user) {
            $m->to($user->email, $user->name)->subject('Thank you for applying your shop to Koolbeans!');
        });

        return redirect(route('home'))->with('messages',
            ['success' => 'Your request has been sent trough! We shall contact you back very soon, stay close!']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReview(Request $request, $id)
    {
        $rating = $request->input('rating');
        $review = $request->input('review');

        if ($rating > 5 || $rating < 1) {
            return redirect()->back()->with('special-message', ['warning' => "An error occured. Please review again."]);
        }

        $coffeeShop = $this->coffeeShop->find($id);

        if ( ! current_user()->canReview($coffeeShop)) {
            return redirect()
                ->back()
                ->with('messages',
                    ['warning' => "You cannot review this coffee shop because you haven't made any order there."]);
        }

        $coffeeShop->addReview($review, $rating);

        return redirect()->back()->with('special-message', ['success' => "Your review has been delivered!"]);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $coffeeShop = $this->coffeeShop->find($id);

        if (null == $request->cookie('seen-' . $coffeeShop->id)) {
            $coffeeShop->views += 1;
            $coffeeShop->save();
        }

        $coffeeShop->save();
        $bestReview = $coffeeShop->getBestReview();

        $response = new \Illuminate\Http\Response(view('coffee_shop.show', compact('coffeeShop', 'bestReview')));
        $response->withCookie(cookie()->forever('seen-' . $coffeeShop->id, 'yes'));

        return $response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return string
     */
    public function update(Request $request, $id)
    {
        foreach ($request->all() as $name => $value) {
            $coffeeShop        = $this->coffeeShop->find($id);
            $coffeeShop->$name = $value;
            $coffeeShop->save();

            return $value;
        }

        return response('Error', 500);
    }

    /**
     * @param int    $coffeeShopId
     * @param string $spec
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleSpec($coffeeShopId, $spec)
    {
        $coffeeShop                    = $this->coffeeShop->find($coffeeShopId);
        $coffeeShop->{'spec_' . $spec} = ! $coffeeShop->{'spec_' . $spec};
        $coffeeShop->save();

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publish()
    {
        $coffeeShop = current_user()->coffee_shop;
        if ($coffeeShop->status != 'accepted') {
            return redirect()->back();
        }

        $products = $coffeeShop->products;
        foreach ($products as $product) {
            if ($coffeeShop->hasActivated($product)) {
                $coffeeShop->status = 'published';
                $coffeeShop->save();

                return redirect()->back()->with('messages', ['success' => 'Coffee shop published!']);
            }
        }

        return redirect(route('coffee-shop.products.index', ['coffeeShop' => $coffeeShop]))->with('messages',
            ['warning' => 'You need a menu with at least 1 product before publishing!']);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function openingTimes()
    {
        $coffeeShop = current_user()->coffee_shop;

        return view('coffee_shop.opening_times', compact('coffeeShop'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOpeningTimes(Request $request)
    {
        $coffeeShop = current_user()->coffee_shop;
        $days       = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            if ($request->has($day)) {
                $time             = $coffeeShop->opening_times()->firstOrNew(['day_of_week' => mb_substr($day, 0, 3)]);
                $time->start_hour = new Carbon($request->input('start_time_' . $day) . ':00');
                $time->stop_hour  = new Carbon($request->input('stop_time_' . $day) . ':00');
                $time->active     = true;
                $time->save();
            } else {
                $time = $coffeeShop->opening_times()->whereDayOfWeek(mb_substr($day, 0, 3))->first();
                if ($time && $time->active) {
                    $time->active = false;
                    $time->save();
                }
            }
        }

        return redirect()->back();
    }
}
