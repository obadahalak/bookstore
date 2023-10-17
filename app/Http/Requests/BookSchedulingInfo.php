<?php

namespace App\Http\Requests;

use App\Models\BooksScheduling;
use Illuminate\Foundation\Http\FormRequest;

class BookSchedulingInfo extends FormRequest
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
            'task_id' => ['required', function ($key, $value, $fail) {
                if (! BooksScheduling::withWhereHas('schedulingInfos', function ($q) use ($value) {

                    $q->where('date', '=', now()->format('Y-m-d'))
                        ->where('id', $value);
                })
                    ->exists()) {
                    $fail('the task didline has been finshed or task its not valid');
                }
            }],
        ];
    }
}
