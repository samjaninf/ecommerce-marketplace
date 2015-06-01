<?php namespace Koolbeans\Http\Requests;

use Koolbeans\Repositories\ProductTypeRepository;

class UpdateProductRequest extends StoreProductRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @param \Koolbeans\Repositories\ProductTypeRepository $typeRepository
     *
     * @return array
     */
    public function rules(ProductTypeRepository $typeRepository)
    {
        $rules = parent::rules($typeRepository);

        $rules['name'] .= ',' . $this->route()->parameter('products');

        return $rules;
    }

}
