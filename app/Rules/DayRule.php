<?php

namespace App\Rules;

use Closure;
use App\Models\Book;
use Illuminate\Contracts\Validation\ValidationRule;

class DayRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public $pages = [];
    public $count_of_selected_pages = 0;
    public function pages_left()
    {
        return Book::getCountPages(request()->book_id) - $this->count_of_selected_pages;
    }
    public function isDublicateDate($array, $date)
    {

        if (collect($array)->where('date', $date)->count() == 1)
            return true;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->count_of_selected_pages = collect($value)->sum('pages');

        $bookCountPages = Book::getCountPages(request()->book_id);

        collect($value)->each(function ($q) use ($value, $fail) {
            if ($this->isDublicateDate($value, $q['date']) == false) {
                $fail('you have dublicated date');
            }
        });



        if ($this->count_of_selected_pages > $bookCountPages) {
            $fail('the selected pages are bigger than count of pages book');
        }
        if ($this->count_of_selected_pages !== $bookCountPages) {
            $fail("you stil have {$this->pages_left()} pages, ");
        }
    }
}

