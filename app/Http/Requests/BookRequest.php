<?php

namespace App\Http\Requests;

use App\Models\Book;
use App\Rules\likeRule;
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

    public function messages()
    {
        return [
            'book_gallery.*.src.image' => 'The book gallery image must be an image.',
            'book_gallery.*.src.required' => 'The book gallery is require',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $generalRules = [
            'name' => ['required', 'min:3', 'max:255'],
            'page_count' => ['required', 'min:1'],
            'overview' => ['required', 'min:3', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'book_cover' => ['required', 'image', 'max:5000'],
            'book_gallery' => ['required', 'array'],
            'book_gallery.*.src' => ['required', 'image', 'max:5000'],
            'book_file' => ['required', 'mimes:pdf', 'max:50000'],
        ];
        if ($this->routeIs('bookByCategory')) {

            return [
                'category_id' => ['required', 'exists:categories,id'],
            ];
        }

        if ($this->routeIs('book.store')) {
            return $generalRules;
        }

        if ($this->routeIs('book.wishlist')) {

            return [
                'status' => ['required', 'boolean'],
                'book_id' => ['required', new likeRule($this->status)],
            ];

        }
        if ($this->routeIs('publish')) {

            return [
                'book_id' => ['required', 'exists:books,id'],
                'status' => ['required', 'boolean', function ($attribute, $value, $fail) {
                    if (Book::find($this->book_id)->active == $value) {
                        $message = $this->status == '1' ? 'aleady published' : ' aleady disabled';
                        $fail('book already ' . $message);
                    }
                }],
            ];

        }
        if ($this->routeIs('evaluateBook')) {

            return [
                'value' => ['required', 'integer', 'min:1', 'max:5'],
                'book_id' => ['required', 'exists:books,id'],
            ];

        }
    }

    public function validatedData()
    {
        $validated = $this->validated();
        $validated['user_id'] = auth()->id();

        return $validated;
    }
}
