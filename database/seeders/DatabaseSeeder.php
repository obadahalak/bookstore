<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\Book;
use App\Models\User;
use App\Models\Image;
// use PharIo\Manifest\Author;
use App\Models\Auther;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::factory(1)
        ->has(
            Image::factory()
                ->count(1)
                ->state(function (array $attributes, User $category) {
                    return ['type' => ''];
                })
        )->create();

        Tag::factory(7)->create();
        Category::factory(8)
            ->has(
                Image::factory()
                    ->count(1)
                    ->state(function (array $attributes, Category $category) {
                        return ['type' => ''];
                    })
            )->create();


            Auther::factory(10)->hasImage(1,['type'=>''])->create();

            $book=Book::factory()->count(50)->hasImages(4,['type'=>'gallary'])

           ->hascoverImage(1,['type'=>'cover']);

           $book->create();
        //    $book->hasImages(4,['type'=>'gallary'])->create();
        //    $gallaryImage->create();-
    }
}
