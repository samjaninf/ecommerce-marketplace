<?php

namespace Koolbeans\Http\Requests;

class RecommendCoffeeShopRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shopname'              => 'required',
            'aboutshop'             => 'required',
            'shoplocation'          => 'required'
        ];
    }
}
