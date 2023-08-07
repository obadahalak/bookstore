<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DayRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $days = ['saterday', 'sunday', 'moday', 'tuesday', 'wednesday', 'tuesday'];
       
        collect($value)->map(function ($value) use ($days, $fail) {

            if (array_search($value, $days) === false) {
                $fail("the day $value is not valid");
            }
        });
    
    }
}
