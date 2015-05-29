<?php namespace Koolbeans\Http\Controllers\Admin;

use Koolbeans\Http\Controllers\Controller;
use Koolbeans\Repositories\ProductRepository;
use Koolbeans\Repositories\ProductTypeRepository;

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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.products.index',
            ['food' => $this->productRepository->food(), 'drinks' => $this->productRepository->drinks()]);
    }

    /**
     * @param \Koolbeans\Repositories\ProductTypeRepository $repository
     * @param string                                        $type
     *
     * @return \Illuminate\View\View
     */
    public function create(ProductTypeRepository $repository, $type = null)
    {
        $product       = $this->productRepository->newInstance();
        $product->type = $type;

        return view('admin.products.create')
            ->with('product', $product)
            ->with('foodTypes', $repository->food())
            ->with('drinkTypes', $repository->drinks());
    }
}
