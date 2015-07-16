<?php

namespace Koolbeans\Http\Controllers;

use Koolbeans\Http\Requests\StoreOfferRequest;
use Koolbeans\Offer;
use Koolbeans\OfferDetail;
use Koolbeans\Product;

class OffersController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $coffeeShop = current_user()->coffee_shop;
        $products   = $coffeeShop->products;
        $offer      = new Offer;

        return view('offers.create', compact('coffeeShop', 'products', 'offer'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $offer = Offer::find($id);
        $offer->details->map(function ($m) { $m->delete(); });
        $offer->delete();

        return redirect()->back();
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleActivation($id)
    {
        $offer = Offer::find($id);
        $offer->activated = ! $offer->activated;
        $offer->save();

        return redirect()->back();
    }

    /**
     * @param \Koolbeans\Http\Requests\StoreOfferRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreOfferRequest $request)
    {
        $coffeeShop = current_user()->coffee_shop;
        $product    = $request->input('product');

        $offer = Offer::create([
            'coffee_shop_id' => $coffeeShop->id,
            'product_id'     => $product,
            'finish_at'      => $request->input('finish_at'),
        ]);

        $sizes = $this->extractSizesFromRequest($request);

        $referencedProducts = $request->input('referenced_product');
        foreach ($request->input('type') as $i => $type) {
            $currentProductId = $referencedProducts[ $i ] !== '' ? $referencedProducts[ $i ] : $product;
            $currentProduct   = Product::find($currentProductId);
            if ( ! $coffeeShop->hasActivated($currentProduct)) {
                $coffeeShop->toggleActivated($currentProduct);
            }

            $isPercent          = $type === 'percent';
            $detail             = new OfferDetail();
            $detail->product_id = $currentProductId;
            $detail->type       = $isPercent ? 'percentage' : $type;
            $detail->amount_xs  = $this->amount($sizes['xs'], $i, $isPercent);
            $detail->amount_sm  = $this->amount($sizes['sm'], $i, $isPercent);
            $detail->amount_md  = $this->amount($sizes['md'], $i, $isPercent);
            $detail->amount_lg  = $this->amount($sizes['lg'], $i, $isPercent);
            $offer->details()->save($detail);
        }

        return redirect(route('coffee-shop.products.index', ['coffeeShop' => $coffeeShop]))->with('messages',
            ['success' => 'Offer created successfully!']);
    }

    /**
     * @param $amounts
     * @param $i
     * @param $isPercent
     *
     * @return float|int
     */
    private function amount($amounts, $i, $isPercent)
    {
        if ( ! isset( $amounts[ $i ] )) {
            return 0;
        }

        if ( ! $isPercent) {
            return abs(round(( (float) $amounts[ $i ] ) * 100));
        }

        return abs(round($amounts[ $i ]));
    }

    /**
     * @param \Koolbeans\Http\Requests\StoreOfferRequest $request
     *
     * @return array
     */
    private function extractSizesFromRequest(StoreOfferRequest $request)
    {
        $sizes = [
            'xs' => $request->input('size-xs') ?: [],
            'sm' => $request->input('size-sm') ?: [],
            'md' => $request->input('size-md') ?: [],
            'lg' => $request->input('size-lg') ?: [],
        ];

        return $sizes;
    }
}
