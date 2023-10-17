<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->email,
            'password' => Hash::make('password'),
            'name' => $this->faker->firstNameFemale(),
            'type' => $this->faker->jobTitle(),
            'bio' => $this->faker->realTextBetween(50, 70),
            'books' => random_int(7, 20),

        ];
    }
}
