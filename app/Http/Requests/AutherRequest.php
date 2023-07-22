<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
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
    public function rules(){
        return [
            'id'=>['required',function($attribute,$value,$fail){
                    if(!User::where('id',$value)->first()->role==User::Author){
                        $fail('author not found ');
                    }
            }],
        ];
    }
    }