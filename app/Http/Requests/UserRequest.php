<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method) {
            case 'GET':

                return [
                    'email' => 'required|email|exists:users,email',
                    'password' => 'required',
                ];

            case 'POST':
                return [
                    'name' => ['required', 'min:3', 'max:20'],
                    'email' => ['required', 'unique:users,email'],
                    'password' => ['required', 'min:5'],
                ];
        }
    }
}
