<?php namespace Koolbeans\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Koolbeans\CoffeeShop;
use Koolbeans\Offer;
use Koolbeans\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionBase;
use Koolbeans\OrderLine;
use Koolbeans\Product;
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
                'name'     => $request->input('username'),
                'email'    => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

            \Auth::login($user);
        } else {
            $user = current_user();
        }

        $shop = $this->coffeeShop->newInstance($request->except(['username', 'email', 'password']));
        $shop->user()->associate($user);
        $shop->status = 'published';
        $shop->save();

        \Mail::send('emails.coffeeshop_registration', ['user' => current_user()], function (Message $m) use ($user) {
            $m->to($user->email, $user->name)->subject('Thank you for applying your shop to Koolbeans!');
        });

        return redirect(route('home'))->with('messages',
            ['success' => 'Thank you for registering with us! We shall contact you back very soon, stay close!']);
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

        $coffeeShop->addReview($review, $rating);

        $u = current_user();
        $u->points += 5;
        $u->save();

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
        $bestReview = $coffeeShop->getBestReview();
        $order = new Order;
        $id    = $request->get('id');

        $orderProduct = new Collection;
        if ($id) {
            if ( ! is_array($id)) {
                $id = new CollectionBase($id);
            }

            foreach ($id as $i) {
                $item = $coffeeShop->products()->find($i);
                if ($item) {
                    $orderProduct->add($item);
                }
            }
        }

        if (( $time = $request->get('time') )) {
            $order->time = new Carbon($time . ':00');
        } else {
            $order->time = Carbon::now()->addHour(1);
        }

        $products = $coffeeShop->products()->orderBy('type', 'desc')->get();

        $fp = new Collection();
        foreach ($products as $product) {
            if ($coffeeShop->hasActivated($product)) {
                $fp->add($product);
            }
        }

        return view('coffee_shop.show', [
            'coffeeShop'    => $coffeeShop,
            'bestReview'    =>  $bestReview,
            'order'         => $order,
            'orderProducts' => $orderProduct,
            'products'      => $fp,
        ]);
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
        $coffeeShop = $this->coffeeShop->find($coffeeShopId);
        $specs      = CoffeeShop::getSpecs();
        $count      = 0;
        if (!$coffeeShop->{'spec_' . $spec}) {
            foreach ($specs as $hasSpec) {
                if ($coffeeShop->{'spec_' . $hasSpec}) {
                    $count += 1;
                }

                if ($count == 5) {
                    if (\Request::ajax()) {
                        return response('', 403);
                    }

                    return redirect()
                        ->back()
                        ->with('messages', ['warning' => 'You can only have 5 attributes activated.']);
                }
            }
        }

        $coffeeShop->{'spec_' . $spec} = ! $coffeeShop->{'spec_' . $spec};
        $coffeeShop->save();

        if (\Request::ajax()) {
            return response('');
        }

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

        return redirect(route('coffee-shop.show', ['coffee-shop' => $coffeeShop->id]));
    }

    /**
     * @return \Illuminate\View\View|\Response
     */
    public function showCurrentOrders()
    {
        $user   = current_user();
        $images = $user->coffee_shop->gallery()->orderBy('position')->limit(3)->get();

        return view('coffee_shop.current_orders', [
            'coffeeShop' => $user->coffee_shop,
            'images'     => $images,
            'firstImage' => $images->isEmpty() ? null : $images[0]->image,
            'orders'     => $user->coffee_shop->orders()
                                              ->where('paid', true)
                                              ->where('status', '!=', 'collected')
                                              ->orderBy('id', 'desc')
                                              ->get(),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $coffeeShopId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function offerUpdate(Request $request, $coffeeShopId)
    {
        $coffeeShop = $this->coffeeShop->find($coffeeShopId);
        if (($coffeeShop->offer_activated = $request->has('offer_activated')) == true) {
            $coffeeShop->offer_drink_only = $request->input('offer_drink_only') == 'drinks_only';
            $coffeeShop->offer_times = $request->input('offer_times');
            $coffeeShop->save();
        }

        return redirect()->back();
    }
}
