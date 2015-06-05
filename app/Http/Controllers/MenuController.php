<?php namespace Koolbeans\Http\Controllers;

use Illuminate\Http\Request;
use Koolbeans\Repositories\CoffeeShopRepository;
use Koolbeans\Repositories\ProductRepository;

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
     * @param \Koolbeans\Repositories\ProductRepository    $productRepository
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShopRepository
     */
    public function __construct(ProductRepository $productRepository, CoffeeShopRepository $coffeeShopRepository)
    {
        $this->productRepository    = $productRepository;
        $this->coffeeShopRepository = $coffeeShopRepository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $drinks     = $this->productRepository->drinks();
        $food       = $this->productRepository->food();
        $coffeeShop = current_user()->coffee_shop;

        return view('products.index')->with(compact('drinks', 'food', 'coffeeShop'));
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
     * @param int                      $coffeeShopId
     * @param int                      $productId
     *
     * @return float
     */
    public function reprice(Request $request, $coffeeShopId, $productId, $size)
    {
        $price      = (int) $request->input('price');
        $coffeeShop = $this->coffeeShopRepository->find($coffeeShopId);
        $product    = $coffeeShop->findProduct($productId);
        $product->pivot->$size = $price;
        $product->pivot->save();

        return number_format($price / 100., 2);
    }
}
