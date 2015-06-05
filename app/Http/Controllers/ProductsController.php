<?php namespace Koolbeans\Http\Controllers;

use Koolbeans\Http\Requests;
use Koolbeans\Http\Requests\CoffeeShopStoreProductRequest;
use Koolbeans\Repositories\ProductRepository;

class ProductsController extends Controller
{
    /**
     * @var \Koolbeans\Repositories\ProductRepository
     */
    private $productRepository;

    /**
     * @param \Koolbeans\Repositories\ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param \Koolbeans\Http\Requests\CoffeeShopStoreProductRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CoffeeShopStoreProductRequest $request)
    {
        $product         = $this->productRepository->create($request);
        $product->status = 'requested';
        $product->save();

        return redirect()
            ->back()
            ->with('messages',
                ['success' => 'Product requested! Wait for a few, we will shortly either accept or decline it.']);
    }

}
