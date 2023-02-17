<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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

        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => ['required','min:3','max:255'],
                    'details' => ['required','min:3','max:255'],
                    'overview' => ['required','min:3','max:255'],
                    'auther_id'=>['required','exists:authers,id'],
                    'category_id'=>['required','exists:categories,id'],
                    'book_cover'=>['required','image','max:5000'],
                    'book_gallery'=>['array','required'],
                    'book_gallery.src'=>['required'],
                    'book_gallery.src.*'=>['image','max:5000'],


                ];

                break;
        }
    }
}
