<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\auther>
 */
class autherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->firstNameFemale(),
            'type'=>$this->faker->jobTitle(),
            'bio'=>$this->faker->realTextBetween(50,70),
            'books'=>random_int(7,20),

        ];
    }
}
