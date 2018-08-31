<?php

namespace App\Http\Requests;

class RegistrationRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'name' => 'required|min:2|max:32',
            'password' => 'required|min:6',
        ];
    }
}
