<?php namespace Koolbeans\Http\Requests;

class CoffeeShopUpdateRequest extends Request
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
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'location.required' => 'The address field is mandatory.',
            'location.regex'    => 'The address should include City and County.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $arr = [
            'location'             => 'required|regex:,.*,',
            'postal_code'          => 'required',
            'phone_number'         => 'required|phone:GB',
            'latitude'             => 'required|numeric',
            'longitude'            => 'required|numeric',
            'place_id'             => 'required',
            'about'                => '',
        ];


        return $arr;
    }
}
