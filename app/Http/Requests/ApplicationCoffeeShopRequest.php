<?php namespace Koolbeans\Http\Requests;

class ApplicationCoffeeShopRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = current_user();

        return $user === null || ! $user->isOwner();
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
            'name'                 => 'required|unique:coffee_shops,name',
            'location'             => 'required|regex:,.*,',
            'postal_code'          => 'required',
            'phone_number'         => 'required|phone:GB',
            'latitude'             => 'required|numeric',
            'longitude'            => 'required|numeric',
            'place_id'             => 'required|google_place_id',
            'g-recaptcha-response' => 'required|google_recaptcha',
            'terms'                => 'required',
        ];

        if (\Auth::guest()) {
            $arr = array_merge($arr, [
                'email'    => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
            ]);
        }

        return $arr;
    }
}
