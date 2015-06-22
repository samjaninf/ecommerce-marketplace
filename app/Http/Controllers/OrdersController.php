<?php namespace Koolbeans\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Koolbeans\Http\Requests;
use Koolbeans\Offer;
use Koolbeans\Order;
use Koolbeans\OrderLine;
use Koolbeans\Product;
use Koolbeans\Repositories\CoffeeShopRepository;
use Laravel\Cashier\StripeGateway;
use Stripe\Charge;
use Stripe\Error\Card;

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
    }

    /**
     * Display a listing of the resource.
     */
    public function index($coffeeShopId = null)
    {
        if (current_user()->role == 'admin') {
            $orders = Order::all();
        } elseif ($coffeeShopId === null) {
            $orders = current_user()->orders;
        } else {
            $coffeeShop = $this->coffeeShopRepository->find($coffeeShopId);
            $orders = $coffeeShop->orders;
        }

        return view('order.index', compact('orders'));
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
            ['coffee_shop' => $coffeeShop, 'drink' => $offer->product->id]));
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

        $order        = new Order;
        $orderProduct = null;
        if (( $id = $request->get('drink') )) {
            $orderProduct = $coffeeShop->products()->find($id);
        }

        if (( $time = $request->get('time') )) {
            $order->time = $time;
        } else {
            $order->time = Carbon::now()->addHour(1);
        }

        $products = $coffeeShop->products()->orderBy('type', 'desc')->get();

        return view('coffee_shop.order.create', [
            'coffeeShop'   => $coffeeShop,
            'order'        => $order,
            'orderProduct' => $orderProduct,
            'products'     => $products,
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
    public function store(Request $request, $coffeeShopId)
    {
        $coffeeShop = $this->coffeeShopRepository->find($coffeeShopId);
        $productIds = $request->input('products');
        $sizes      = $request->input('productSizes');

        $order                 = new Order;
        $order->user_id        = current_user()->id;
        $order->coffee_shop_id = $coffeeShopId;

        $order->pickup_time = $request->input('time');

        $lines   = [];
        $sizeIdx = 0;
        foreach ($productIds as $productId) {
            /** @var Product $product */
            $product = $coffeeShop->products()->find($productId);

            $lines[]                 = $currentLine = new OrderLine;
            $currentLine->product_id = $productId;
            $currentLine->size       = null;

            if ( ! $product) {
                return redirect()->back()->with('messages', ['danger' => 'Error during your order. Please try again.']);
            }

            if ($product->type == 'drink') {
                $size = $sizes[ $sizeIdx++ ];
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

        if (\Session::has('offer-used')) {
            $offer = Offer::find(\Session::get('offer-used'));
            $order->offer_id = $offer->id;
            $this->applyOfferOnOrder($offer, $lines);
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
    public function checkout(Request $request, $coffeeShopId, $orderId)
    {
        $user  = current_user();
        $order = Order::find($orderId);

        if ( ! $user->hasStripeId()) {
            try {
                $gateway  = new StripeGateway($user);
                $customer = $gateway->createStripeCustomer($request->input('stripeToken'));
            } catch (Card $e) {
                return view('coffee_shop.order.review', [
                    'order'      => $order,
                    'coffeeShop' => $this->coffeeShopRepository->find($coffeeShopId),
                ])->with('messages', [
                    'danger' => 'There was a problem during the authorization. ' .
                                'It should not happen unless you cannot afford your order. Please try again.',
                ]);
            }

            $user->setStripeId($customer->id);
            $user->save();
        } elseif ($request->has('stripeToken')) {
            $user->updateCard($request->input('stripeToken'));
        }

        $previous = $user->transactions()->where('charged', '=', false)->sum('amount');
        $amount   = $order->price;

        if ($amount + $previous > 1500) {
            try {
                if ( ! $user->charge($amount + $previous, ['currency' => 'gbp'])) {
                    return view('coffee_shop.order.review', [
                        'order'      => $order,
                        'coffeeShop' => $this->coffeeShopRepository->find($coffeeShopId),
                    ])->with('messages', [
                        'danger' => 'There was a problem during the authorization. ' .
                                    'It should not happen unless you cannot afford your order. Please try again.',
                    ]);
                }
            } catch (Card $e) {
                return view('coffee_shop.order.review', [
                    'order'      => $order,
                    'coffeeShop' => $this->coffeeShopRepository->find($coffeeShopId),
                ])->with('messages', [
                    'danger' => 'There was a problem during the authorization. ' .
                                'It should not happen unless you cannot afford your order. Please try again.',
                ]);
            }

            $user->transactions()->create(['amount' => $amount, 'charged' => true]);
            $transactions = $user->transactions()->where('charged', '=', false)->get();

            foreach ($transactions as $t) {
                $stripe_charge_id = $t->stripe_charge_id;
                if ($stripe_charge_id) {
                    $charge = Charge::retrieve($stripe_charge_id);
                    $charge->refunds->create();
                }

                $t->charged = true;
                $t->save();
            }

            $charged = true;
        } else {
            try {
                if ( ! $previous && ! $charge = $user->charge(1500, ['currency' => 'gbp', 'capture' => false])) {
                    return view('coffee_shop.order.review', [
                        'order'      => $order,
                        'coffeeShop' => $this->coffeeShopRepository->find($coffeeShopId),
                    ])->with('messages', [
                        'danger' => 'There was a problem during the authorization. ' .
                                    'It should not happen unless you cannot afford your order. Please try again.',
                    ]);
                }
            } catch (Card $e) {
                return view('coffee_shop.order.review', [
                    'order'      => $order,
                    'coffeeShop' => $this->coffeeShopRepository->find($coffeeShopId),
                ])->with('messages', [
                    'danger' => 'There was a problem during the authorization. ' .
                                'It should not happen unless you cannot afford your order. Please try again.',
                ]);
            }

            $user->transactions()->create([
                'amount'           => $amount,
                'charged'          => false,
                'stripe_charge_id' => ( isset( $charge ) ? $charge['id'] : null ),
            ]);
        }

        $order->paid = true;
        $order->save();

        $chargedMessage = 'You have been correctly charged for your order. Here is your receipt.';
        $warningMessage = 'An authorization of £ 15 has been made to your bank. ' .
                          'However, we will not charge you for that amount. ' .
                          'You wont be charged until you spend more than £ 15 in our shops. ' .
                          'In 6 days, you will automatically be charged for the correct amount. ';
        $successMessage = 'Your order has been added to your tip!';
        $warningMessage = ( $previous ) ? ( $warningMessage ) : $successMessage;

        return redirect(route('order.success', ['order' => $order]))->with('messages',
            ['success' => ( isset( $charged ) ) ? $chargedMessage : $warningMessage]);
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
        $order = Order::find($id);
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

}
