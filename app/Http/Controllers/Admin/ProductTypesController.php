<?php namespace Koolbeans\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Koolbeans\Http\Controllers\Controller;
use Koolbeans\Repositories\ProductTypeRepository;

class ProductTypesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request                      $request
     * @param \Koolbeans\Repositories\ProductTypeRepository $repository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request, ProductTypeRepository $repository)
    {
        $repository->create($request->get('value'), $request->get('type'));

        return response()->json(['status' => 'OK']);
    }
}
