<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\book>
 */
class bookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->jobTitle(),
            // 'details'=>$this->faker->realTextBetween(50,100),
            'overview'=>$this->faker->realTextBetween(100,200),
            'rating'=>random_int(1,5),
            'user_id'=>User::inRandomOrder()->get()->value('id'),
            'category_id'=>category::inRandomOrder()->get()->value('id'),
            'active'=>1,
        ];
    }
}
