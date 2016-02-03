<?php namespace Koolbeans\Http\Controllers;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Collection as CollectionBase;
use Koolbeans\Http\Requests;
use Koolbeans\Offer;
use Koolbeans\Order;
use Koolbeans\OrderLine;
use Koolbeans\Product;
use Koolbeans\Repositories\CoffeeShopRepository;
use Laravel\Cashier\StripeGateway;
use Session;
use Stripe\Charge;
use Stripe\Error\Card;
use Jenssegers\Agent\Agent;
use Koolbeans\MobileToken;
class OrdersController extends Controller
{
    /**
     * @var \Koolbeans\Repositories\CoffeeShopRepository
     */
    private $coffeeShopRepository;

    /**
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShopRepository
     */
    public function __construct(CoffeeShopRepository $coffeeShopRepository)
    {
        $this->coffeeShopRepository = $coffeeShopRepository;

        $this->middleware('open', ['only' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($coffeeShopId = null)
    {
        if (current_user()->role == 'admin') {
            $orders = Order::all();
        }

        if ( Request::get('coffee_shop') >= 1 ) {
            $coffeeShop = $this->coffeeShopRepository->find(Request::get('coffee_shop'));
            if (empty($orders)) {
                $orders = $coffeeShop->orders()->orderBy('created_at', 'desc')->get();
            }
          
            $images = $coffeeShop->gallery()->orderBy('position')->limit(3)->get();

        }
        
        return view('order.index', compact('orders', 'coffeeShop'))->with([
            'images'     => $images,
            'firstImage' => $images->isEmpty() ? null : $images[0]->image,
        ]);
    }

    /**
     * @param $orderId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function nextStatus($orderId)
    {
        $order         = Order::find($orderId);
        $order->status = $order->getNextStatus();
        $order->save();

        return redirect()->back();
    }

    /**
     * @param int $offerId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function applyOffer($offerId)
    {
        \Session::put('offer-used', $offerId);
        $offer      = Offer::find($offerId);
        $coffeeShop = $offer->coffee_shop;

        return redirect(route('coffee-shop.order.create',
            ['coffee_shop' => $coffeeShop, 'id[]' => $offer->product->id]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $coffeeShopId
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, $coffeeShopId)
    {
        $coffeeShop = $this->coffeeShopRepository->find($coffeeShopId);

        $order = new Order;

        $id = $coffeeShopId;

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
        if ($request->get('time') == 'onarrival') {
            $order->time = Carbon::now();
        } else {
            if (( $time = $request->get('time') )) {
                $order->time = new Carbon($time . ':00');
            } else {
                $order->time = Carbon::now()->addHour(1);
            }
        }

        $products = $coffeeShop->products()->orderBy('type', 'ascr')->get();

        $fp = new Collection();
        foreach ($products as $product) {
            if ($coffeeShop->hasActivated($product)) {
                array_push($product, $coffeeShop->getNameFor($product));
                $fp->add($product);
            }
        }

        //times 10, 15, 20, 25, 30
        $now = strtotime("-1 hour", strtotime($order->time));

        $times = array(
            "In 5 minutes"     => 5,
            "In 10 minutes"    => 10, 
            "In 15 minutes"    => 15, 
            "In 20 minutes"    => 20, 
            "In 25 minutes"    => 25, 
            "In 30 minutes"    => 30
        );
        $inTimes = array();
        foreach ( $times as $string => $time ) {
            $inTime = strtotime("+" . $time . " minutes", $now);
            $inTime = date("H:i", $inTime);
            $inTimes[$string] = $inTime;
        }
        
        $agent = new Agent();

        return view('coffee_shop.order.create', [
            'coffeeShop'    => $coffeeShop,
            'order'         => $order,
            'orderProducts' => $orderProduct,
            'products'      => $fp,
            'times'         => $inTimes,
            'agent'         => $agent
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $coffeeShopId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($coffeeShopId, Request $request)
    {
        $coffeeShop = $this->coffeeShopRepository->find($coffeeShopId);
        $productIds = Request::input('products');
        $sizes      = Request::input('productSizes');

        $order                 = new Order;
        $order->user_id        = current_user()->id;
        $order->coffee_shop_id = $coffeeShopId;
        $time = Request::input('time');
        if ($time == 'onarrival') {
            $order->make_on_arriving = 1;
            $order->pickup_time = 'Make On Arrival';
        } else {
            $order->pickup_time = Request::input('time');
        }

        $lines   = [];
        foreach ($productIds as $i => $productId) {
            /** @var Product $product */
            $product = $coffeeShop->products()->find($productId);

            $lines[]                 = $currentLine = new OrderLine;
            $currentLine->product()->associate($product);
            $currentLine->size       = null;

            if ( ! $product) {
                return redirect()->back()->with('messages', ['danger' => 'Error during your order. Please try again.']);
            }

            if ($product->type == 'drink') {
                $size = $sizes[ $i ];
                if ($size == null || ! $coffeeShop->hasActivated($product, $size)) {
                    return redirect()
                        ->back()
                        ->with('messages', ['danger' => 'Error during your order. Please try again.']);
                }

                $currentLine->size  = $size;
                $currentLine->price = $product->pivot->$size;
            } else {
                $currentLine->size  = 'sm';
                $currentLine->price = $product->pivot->sm;
            }
        }

        if ($coffeeShop->offer_activated) {
            $now = Carbon::now();
            $offPeak = $now->between(new Carbon(Carbon::now()->setTime(9, 45)), new Carbon(Carbon::now()->setTime(11, 45)));
            if ($coffeeShop->offer_times == 'off-peak' && $offPeak && $now->day != Carbon::SATURDAY && $now->day != Carbon::SUNDAY ||
                $coffeeShop->offer_times == 'off-peak-weekends' && $offPeak ||
                $coffeeShop->offer_times == 'all') {
                $tmp = new CollectionBase($lines);
                $count = $tmp->count();
                if ($coffeeShop->offer_drink_only) {
                    $tmp = $tmp->filter(function ($row) {
                        return $row->product->type == 'drink';
                    });
                }
                $reduced = $tmp->take(floor($count / 2));
                foreach ($reduced as $line) {
                    $line->price = ceil($line->price / 2);
                }
            }
        }

        $order->save();
        foreach ($lines as $line) {
            $order->order_lines()->save($line);
        }

        $order->price = $order->order_lines()->sum('price');
        $order->save();

        return view('coffee_shop.order.review', ['order' => $order, 'coffeeShop' => $coffeeShop]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int                      $coffeeShopId
     * @param int                      $orderId
     *
     * @return \Illuminate\View\View
     */
    public function checkout( $coffeeShopId, $orderId)
    {
        $user  = current_user();
        $order = Order::find($orderId);

        if ($order->paid) {
            return redirect(route('order.success', ['order' => $order]));
        }

        $coffeeShop = $this->coffeeShopRepository->find($coffeeShopId);


        if ( ! $user->hasStripeId()) {
            try {
                $gateway  = new StripeGateway($user);
                $customer = $gateway->createStripeCustomer(Request::input('stripeToken'));
            } catch (Card $e) {
                return view('coffee_shop.order.review', [
                    'order'      => $order,
                    'coffeeShop' => $coffeeShop,
                ])->with('messages', [
                    'danger' => 'There was a problem during the authorization. ' .
                                'It should not happen unless you cannot afford your order. Please try again.',
                ]);
            }

            $user->setStripeId($customer->id);
            $user->save();
        } elseif (Request::has('stripeToken')) {
            $user->updateCard(Request::input('stripeToken'));
        }

        $previous = $user->transactions()->where('charged', '=', false)->where('coffee_shop_id', '=', $coffeeShopId)->sum('amount');
        $amount   = $order->price;

        \Mail::send('emails.order_received',
            ['coffeeShop' => $coffeeShop, 'user' => current_user(), 'order' => $order],
            function (Message $m) use ($coffeeShop) {
                $m->to($coffeeShop->user->email, $coffeeShop->user->name)
                    ->subject('You have received an order!');
            });
        try {
            if ( ! $user->charge($amount, array(
                'currency'         => 'gbp',
                'customer' => $user->stripe_id,
                'application_fee'  => number_format($amount * 0.09, 0, '.', ''),
                'destination'      => $coffeeShop->stripe_user_id
            ),
            array('stripe_account'   => 'ca_7hpA87d09JFpXVNWgswHbG4ZnzhMyZ2L')
            )) {
                return view('coffee_shop.order.review', [
                    'order'      => $order,
                    'coffeeShop' => $coffeeShop,
                ])->with('messages', [
                    'danger' => 'There was a problem during the authorization. ' .
                                'It should not happen unless you cannot afford your order. Please try again.',
                ]);
            }
        } catch (Card $e) {
            return view('coffee_shop.order.review', [
                'order'      => $order,
                'coffeeShop' => $coffeeShop,
            ])->with('messages', [
                'danger' => 'There was a problem during the authorization. ' .
                            'It should not happen unless you cannot afford your order. Please try again.',
            ]);
        }

        $user->transactions()->create(['amount' => $amount, 'charged' => true, 'coffee_shop_id' => $coffeeShopId]);
        $transactions = $user->transactions()->where('charged', '=', false)->where('coffee_shop_id', '=', $coffeeShopId)->get();

        $refund = 0;
        foreach ($transactions as $t) {
            $stripe_charge_id = $t->stripe_charge_id;
            if ($stripe_charge_id) {
                $charge = Charge::retrieve($stripe_charge_id);
                $charge->refunds->create();
            }

            $t->charged = true;
            $t->save();
            $refund += $t->amount;
        }

        $charged = true;

        \Mail::send('emails.payment_charged', [
            'user'    => current_user(),
            'amount'  => $amount / 100.,
            'refund'  => $refund / 100.,
            'initial' => '15.00',
        ], function (Message $m) use ($user) {
            $m->to($user->email, $user->name)->subject('You have been charged.');
        });

        $order->paid = true;
        $order->save();

        $user->points += 5;
        $user->save();

        $successMessage = 'Your coffee has been ordered!';
        $warningMessage = $successMessage;

        \Mail::send('emails.order_completed',
            ['user' => current_user(), 'order' => $order, 'coffeeShop' => $coffeeShop],
            function (Message $m) use ($user) {
                $m->to($user->email, $user->name)->subject('Your order has been sent!');
            });

        $tokens = MobileToken::where('user_id', $coffeeShop->id);
        if ($tokens->isEmpty()) {
            \Mail::send('emails.no_active_token_found', ['user' => $coffeeShop->user],
                function (Message $m) use ($coffeeShop) {
                    $m->to($coffeeShop->user->email, $coffeeShop->user->name)
                      ->subject('Make sure to install the application');
                });
        } else {
            $notification = json_encode([
                'tokens'       => $tokens->map(function ($token) {
                    return $token->token;
                })->all(),
                'notification' => [
                    'alert'   => 'You have a new order! Pickup time: ',
                    'android' => [
                        'payload' => $payload = [
                            'orderId' => $order->id,
                        ],
                    ],
                    'ios' => [
                        'payload' => $payload = [
                            'orderId' => $order->id,
                        ],
                    ]
                ],
            ]);
            $ionic        = new Client([
                'base_url' => 'https://push.ionic.io/api/v1/',
                'defaults' => [
                    'auth'    => [config('services.ionic.app_secret'), ''],
                    'headers' => [
                        'Content-Type'           => 'application/json',
                        'X-Ionic-Application-Id' => config('services.ionic.app_id'),
                    ],
                ],
            ]);

            try {
                $ionic->post('push', ['body' => $notification]);
            } catch (Exception $e) {
            }
        }

        return redirect(route('order.success', ['order' => $order]))
            ->with('messages', ['success' => $warningMessage])
            ->with('newauth', $previous ? 'no' : 'yes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $order      = Order::find($id);
        $coffeeShop = $order->coffee_shop;

        return view('coffee_shop.order.success', compact('order', 'coffeeShop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param \Koolbeans\Offer       $offer
     * @param \Koolbeans\OrderLine[] $order
     */
    private function applyOfferOnOrder(Offer $offer, array $order)
    {
        $valid = false;
        foreach ($order as $orderLine) {
            if ($orderLine->product == $offer->product) {
                $valid = true;
                break;
            }
        }

        if ($valid) {
            foreach ($offer->details as $detail) {
                foreach ($order as $orderLine) {
                    if ($orderLine->product == $detail->product) {
                        if ($detail->type == 'free') {
                            $orderLine->price = 0;
                        } elseif ($detail->type == 'flat') {
                            $orderLine->price -= $detail->{'amount_' . $orderLine->size};
                        } else {
                            $orderLine->price *= $detail->{'amount_' . $orderLine->size} / 100.;
                        }

                        break;
                    }
                }
            }
        }
    }

    /**
     * @param $orderId
     *
     * @return string
     */
    public function tweet($orderId)
    {
        $order = Order::find($orderId);
        if ($order->user_id != \Auth::user()->id) {
            return '';
        }

        $user = \Auth::user();
        $user->points += 5;
        $user->save();

        return 'success';
    }

}
