<?php namespace Koolbeans\Http\Controllers;

use Illuminate\Http\Request;
use Koolbeans\Http\Requests;
use Koolbeans\Order;
use Koolbeans\OrderLine;
use Koolbeans\Repositories\CoffeeShopRepository;
use Laravel\Cashier\StripeGateway;
use Stripe\Charge;

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
     *
     * @return Response
     */
    public function index()
    {
        //
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
        }

        return view('coffee_shop.order.create', [
            'coffeeShop'   => $coffeeShop,
            'order'        => $order,
            'orderProduct' => $orderProduct,
            'products'     => $coffeeShop->products()->orderBy('type', 'desc')->get(),
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

        $order          = new Order;
        $order->user_id = current_user()->id;

        $order->pickup_time = $request->input('time');

        $lines   = [];
        $sizeIdx = 0;
        foreach ($productIds as $productId) {
            $product = $coffeeShop->products()->find($productId);

            $lines[]                 = $currentLine = new OrderLine;
            $currentLine->product_id = $productId;
            $currentLine->size       = null;

            if ( ! $product) {
                return redirect()->back();
            }

            if ($product->type == 'drink') {
                $size = $sizes[ $sizeIdx++ ];
                if ($size == null || ! $coffeeShop->hasActivated($product, $size)) {
                    return redirect()->back();
                }
                $currentLine->size  = $size;
                $currentLine->price = $product->pivot->$size;
            } else {
                $currentLine->size  = 'sm';
                $currentLine->price = $product->pivot->sm;
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
    public function checkout(Request $request, $coffeeShopId, $orderId)
    {
        $user  = current_user();
        $order = Order::find($orderId);

        if ( ! $user->hasStripeId()) {
            $gateway  = new StripeGateway($user);
            $customer = $gateway->createStripeCustomer($request->input('stripeToken'));
            $user->setStripeId($customer->id);
            $user->save();
        }

        $order->paid = true;
        $order->save();

        $previous = $user->transactions()->where('charged', '=', false)->sum('amount');
        $amount   = $order->price;

        if ($amount + $previous > 1500) {
            if ( ! $user->charge($amount + $previous, ['currency' => 'gbp'])) {
                return redirect()->back();
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
        } else {
            if (! $previous && ! $charge = $user->charge(1500, ['currency' => 'gbp', 'capture' => false])) {
                return redirect()->back();
            }

            $user->transactions()->create(['amount' => $amount, 'charged' => false, 'stripe_charge_id' => (isset($charge) ? $charge : null)]);
        }

        return view('coffee_shop.order.success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
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

}
