<?php

namespace Koolbeans\Http\Requests;

class StoreOfferRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return current_user()->isOwner();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product'            => 'required|exists:products,id',
            'finish_at'          => 'required',
            'referenced_product' => 'array',
            'type'               => 'array',
        ];
    }
}
