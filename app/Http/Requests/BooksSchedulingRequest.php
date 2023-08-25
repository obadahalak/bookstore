<?php

namespace App\Http\Requests;

use App\Models\Book;
use App\Rules\DayRule;
use App\Models\BooksScheduling;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use App\Rules\SchedulingTransactionRule;
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
    public function messages(): array
    {
        return [
            'book_id.unique' => 'you have already have this book in your scheduling',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'days' => ['array', new DayRule()],
            'days.*.date' => ['required', 'date_format:Y-m-d', 'after_or_equal:' . now()->format('Y-m-d')],
            'days.*.pages' => ['required', 'numeric'],
            'book_id' => [
                'required',
                Rule::unique('books_schedulings')->where(fn (Builder $query)
                => $query->where('user_id', auth()->id()))
            ],
        ];
    }
    public function validatedData()
    {
        $validated = $this->validated();
        $validated['duration'] = count(request()->days);
        $validated['user_id'] = auth()->id();
        $validated['days'] = collect($validated['days'])->map(function ($value) {
            return array_merge($value, ['status' => false]);
        });

        return $validated;
    }
}
