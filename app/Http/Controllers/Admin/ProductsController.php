<?php namespace Koolbeans\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Koolbeans\Http\Controllers\Controller;
use Koolbeans\Http\Requests\StoreProductRequest;
use Koolbeans\Http\Requests\UpdateProductRequest;
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
            ['food' => $this->productRepository->food(true), 'drinks' => $this->productRepository->drinks(true)]);
    }

    /**
     * @param \Koolbeans\Repositories\ProductTypeRepository $repository
     * @param \Illuminate\Http\Request                      $request
     *
     * @return \Illuminate\View\View
     */
    public function create(ProductTypeRepository $repository, Request $request)
    {
        $product       = $this->productRepository->newInstance();
        $product->type = $request->get('type');

        return view('admin.products.create')
            ->with('product', $product)
            ->with('foodTypes', $repository->food())
            ->with('drinkTypes', $repository->drinks());
    }

    /**
     * @param \Koolbeans\Repositories\ProductTypeRepository $repository
     * @param int                                           $id
     *
     * @return $this
     */
    public function edit(ProductTypeRepository $repository, $id)
    {
        $product = $this->productRepository->find($id);

        return view('admin.products.edit')
            ->with('product', $product)
            ->with('foodTypes', $repository->food())
            ->with('drinkTypes', $repository->drinks());
    }

    /**
     * @param \Koolbeans\Http\Requests\StoreProductRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productRepository->create($request);

        return redirect(route('admin.products.index'))->with('messages',
            ['success' => "The $product->type $product->name has been created!"]);
    }

    /**
     * @param \Koolbeans\Http\Requests\UpdateProductRequest $request
     * @param int                                           $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productRepository->update($id, $request);

        return redirect(route('admin.products.index'))->with('messages',
            ['success' => "The $product->type $product->name has been updated!"]);
    }

    /**
     * @param \Koolbeans\Repositories\ProductRepository $productRepository
     * @param int                                       $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ProductRepository $productRepository, $id, $force = false)
    {
        if ($force) {
            $product = $productRepository->delete($id);
        } else {
            $product = $productRepository->disable($id);
        }

        return redirect(route('admin.products.index'))->with('messages',
            ['warning' => "The $product->type $product->name has been correctly ". ($force ? 'deleted' : 'disabled') ."."]);
    }

    /**
     * @param \Koolbeans\Repositories\ProductRepository $productRepository
     * @param int                                       $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(ProductRepository $productRepository, $id)
    {
        $product = $productRepository->enable($id);

        return redirect(route('admin.products.index'))->with('messages',
            ['success' => "The $product->type $product->name has been correctly enabled."]);
    }
}
