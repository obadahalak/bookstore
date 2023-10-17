<?php

namespace App\Rules;

use App\Models\Book;
use Illuminate\Contracts\Validation\Rule;

class likeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if ($this->status == 1) {
            if (Book::Active()->find($value)) {
                return true;
            }

            return false;
        }

        $like = auth()->user()->likes()->where('book_id', $value)->first();
        if ($like) {
            return true;
        }

        return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'the book not found in your wishlist.';
    }
}
