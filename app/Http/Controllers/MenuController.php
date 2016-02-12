<?php namespace Koolbeans\Http\Controllers;

use Illuminate\Http\Request;
use Koolbeans\Repositories\CoffeeShopRepository;
use Koolbeans\Repositories\ProductRepository;
use Koolbeans\Repositories\ProductTypeRepository;

class MenuController extends Controller
{
    /**
     * @var \Koolbeans\Repositories\ProductRepository
     */
    private $productRepository;
    /**
     * @var \Koolbeans\Repositories\CoffeeShopRepository
     */
    private $coffeeShopRepository;
    /**
     * @var \Koolbeans\Repositories\ProductTypeRepository
     */
    private $productTypeRepository;

    /**
     * @param \Koolbeans\Repositories\ProductRepository     $productRepository
     * @param \Koolbeans\Repositories\CoffeeShopRepository  $coffeeShopRepository
     * @param \Koolbeans\Repositories\ProductTypeRepository $productTypeRepository
     */
    public function __construct(
        ProductRepository $productRepository, CoffeeShopRepository $coffeeShopRepository,
        ProductTypeRepository $productTypeRepository
    ) {
        $this->productRepository     = $productRepository;
        $this->coffeeShopRepository  = $coffeeShopRepository;
        $this->productTypeRepository = $productTypeRepository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $drinks     = $this->productRepository->drinks();
        $food       = $this->productRepository->food();
        $coffeeShop = $this->coffeeShopRepository->find($request->coffee_shop);
        $drinkTypes = $this->productTypeRepository->drinks();
        $foodTypes  = $this->productTypeRepository->food();
        $offers     = $coffeeShop->offers()->with('details')->get();
        $images     = $coffeeShop->gallery()->orderBy('position')->limit(3)->get();

        return view('products.index')->with(compact('drinks', 'food', 'coffeeShop', 'drinkTypes', 'foodTypes',
            'offers'))->with([
            'images'     => $images,
            'firstImage' => $images->isEmpty() ? null : $images[0]->image,
        ]);
    }

    /**
     * @param int  $coffeeShopId
     * @param int  $productId
     * @param null $size
     */
    public function toggle($coffeeShopId, $productId, $size = null)
    {
        $coffeeShop = $this->coffeeShopRepository->find($coffeeShopId);
        $product    = $this->productRepository->find($productId);
        $coffeeShop->toggleActivated($product, $size);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int                      $coffeeShopId
     * @param int                      $productId
     *
     * @return string
     */
    public function rename(Request $request, $coffeeShopId, $productId)
    {
        $coffeeShop           = $this->coffeeShopRepository->find($coffeeShopId);
        $product              = $coffeeShop->findProduct($productId);
        $product->pivot->name = $request->input('name');
        $product->pivot->save();

        return $product->pivot->name;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $coffeeShopId
     * @param                          $productId
     *
     * @return string
     */
    public function changeDescription(Request $request, $coffeeShopId, $productId)
    {
        if ($request->input('description') == 'DESC' || $request->input('description') == '') {
            return 'DESC';
        }

        $coffeeShop                  = $this->coffeeShopRepository->find($coffeeShopId);
        $product                     = $coffeeShop->findProduct($productId);
        $product->pivot->description = $request->input('description');
        $product->pivot->save();

        return $product->pivot->description;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int                      $coffeeShopId
     * @param int                      $productId
     *
     * @return float
     */
    public function reprice(Request $request, $coffeeShopId, $productId, $size)
    {
        $price                 = (int) $request->input('price');
        $coffeeShop            = $this->coffeeShopRepository->find($coffeeShopId);
        $product               = $coffeeShop->findProduct($productId);
        $product->pivot->$size = $price;
        $product->pivot->save();

        return number_format($price / 100., 2);
    }
}
