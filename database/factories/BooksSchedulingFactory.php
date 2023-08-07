<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BooksScheduling>
 */
class BooksSchedulingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $days = [
            'saterday' => [
                'status' => 1
            ],
            'sunday' => [
                'status' => 0
            ],
            'moday' => [
                'status' => 0
            ],
        ];
      
        return [
            'user_id'=>User::first()->id,
            'days' => $days,
            'book_id' => Book::first()->id,
            'pages_per_day' => 20,
            'duration' => 15,


        ];
    }
}
