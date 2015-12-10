<?php namespace Koolbeans\Http\Requests;

class UserRequest extends Request
{

    public function rules()
    {
        return [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255',
            'drink' => 'required',
        ];
    }

    public function authorize()
    {
        return \Auth::check();
    }
}
