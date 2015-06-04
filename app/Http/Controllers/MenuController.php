<?php namespace Koolbeans\Http\Controllers;

use Koolbeans\Repositories\ProductRepository;

class MenuController extends Controller
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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $drinks = $this->productRepository->drinks();
        $food = $this->productRepository->food();

        return view('products.index')->with(compact('drinks', 'food'));
    }
}
