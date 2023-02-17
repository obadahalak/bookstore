<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutherRequest extends FormRequest
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
        $updateUserRule=[
            'old_password'=>'nullable',
            'new_password'=>['required_with:old_password','min:6','max:30','confirmed'],
        ];
        $autherRules = [
            'email'=>['required','unique:authers,email'],
            'password' => ['required', 'min:6', 'max:30'],
            'name' => ['required', 'min:3', 'max:20'],
            'type' => ['required'],
            'bio' => ['required', 'min:5'],
            'image' => ['image', 'max:5000']
        ];

        switch ($this->method()) {
            case 'GET':

                return [
                    'email' => ['required', 'email', 'exists:authers,email'],
                    'password' => 'required',
                ];
                break;

            case 'POST':
                if ($this->route()->getName() == 'updateAuther') {
                    $autherRules['email'][1] = 'unique:authers,email,' . auth('auther')->user()->id;
                    $autherRules['password'][0] = 'nullable';
                    return [...$updateUserRule, ...$autherRules];
                }
                return
                    $autherRules;

                break;
        }
    }
}
