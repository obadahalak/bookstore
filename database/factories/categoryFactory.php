<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class categoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'name'=>$this->faker->title,
            'title'=>$this->faker->text(10),
            'count_of_books'=>random_int(20,100),
            // 'description'=>$this->faker->realTextBetween(40,100),
            // 'tag_id'=>Tag::inRandomOrder()->get()->value('id'),
            // 'image'=>$this->faker->imageUrl(),
        ];
    }
}
