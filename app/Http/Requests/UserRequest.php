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
        $userRules = [
            'name' => ['required', 'min:3', 'max:20'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'min:5'],
            'bio' => ['required'],
            'address' => ['required'],
            'image' => ['image', 'max:5000'],
        ];
        switch ($this->method()) {
            case 'GET':

                return [
                    'email' => ['required', 'email', 'exists:users,email'],
                    'password' => 'required',
                ];
                break;

            case 'POST':
                if($this->route()->getName()=='updateUser'){
                    $userRules['email'][1]='unique:users,email,'.auth()->user()->id;
                    return $userRules;
                }
                return [
                    'name' => ['required', 'min:3', 'max:20'],
                    'email' => ['required', 'unique:users,email'],
                    'password' => ['required', 'min:5'],
                    'bio' => ['required'],
                    'address' => ['required'],
                    'image' => ['image', 'max:5000'],
                ];

                break;
        }
    }

    public function messages()
    {

        switch ($this->method()) {
            case 'GET':
                return [
                    'email.exists' => 'email or password not correct',
                ];
                break;

            case 'POST':
                return [
                    ////default messages
                ];
                break;
        }
    }
}
