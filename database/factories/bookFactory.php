<?php

namespace Database\Factories;

use App\Models\auther;
use App\Models\category;
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
            'details'=>$this->faker->realTextBetween(50,100),
            'overview'=>$this->faker->realTextBetween(100,200),
            'rating'=>random_int(1,5),
            'auther_id'=>auther::all()->random()->id,
            'category_id'=>category::all()->random()->id,
        ];
    }
}
