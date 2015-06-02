<?php namespace Koolbeans\Http\Requests;

use Illuminate\Contracts\Auth\Guard;

class UpdateCoffeeShopRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'                 => 'required|unique:coffee_shops,name',
            'location'             => 'required|regex:,.*,',
            'postal_code'          => 'required',
            'phone_number'         => 'required|phone:GB',
        ];
    }

}
