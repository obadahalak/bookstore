<?php

namespace App\Http\Requests;

use App\Models\Book;
use App\Rules\DayRule;
use Illuminate\Foundation\Http\FormRequest;

class BooksSchedulingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'days' => ['array', 'required'],
            'days.*'=>['required',new DayRule()],
            'status' => 'boolean',
            'pages_per_day' => ['required', 'numeric', 'min:1'],
            'book_id' => ['required', 'exists:books,id']
        ];
    }
    public function validatedData()
    {
        $validated = $this->validated();
        $book_page = Book::find(request()->book_id)->page_count;
        $validated['duration'] = $book_page / request()->pages_per_day;
        $validated['user_id'] = auth()->id();
        $validated['days'] = collect($validated['days'])->map(function ($value) {
            return  [ $value => ['status' => false]];
        
        });

        return $validated;
    }
}
