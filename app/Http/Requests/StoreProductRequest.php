<?php namespace Koolbeans\Http\Requests;

use Illuminate\Contracts\Auth\Guard;
use Koolbeans\Repositories\ProductTypeRepository;

class StoreProductRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     *
     * @return bool
     */
    public function authorize(Guard $auth)
    {
        return ! $auth->guest() && current_user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param \Koolbeans\Repositories\ProductTypeRepository $productTypeRepository
     *
     * @return array
     */
    public function rules(ProductTypeRepository $productTypeRepository)
    {
        $rules = [
            'name' => 'required|unique:products,name',
            'type' => 'required|in:food,drink',
        ];

        $types         = $this->request->get('product_type');
        $requestedType = $this->request->get('type');
        if ( ! $productTypeRepository->check($types, $requestedType)) {
            foreach ($types as $name => $value) {
                $productType = $productTypeRepository->findByName($name);
                if ($productType !== $requestedType) {
                    $this->request->remove('product_type.' . $name);
                }
            }
        }

        return $rules;
    }

}
