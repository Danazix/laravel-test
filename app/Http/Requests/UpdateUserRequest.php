<?php

namespace App\Http\Requests;

class UpdateUserRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'email|unique:users',
            'name' => 'min:2|max:32',
            'password' => 'min:6',
        ];
    }
}
