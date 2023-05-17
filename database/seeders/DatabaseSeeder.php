<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\Book;
use App\Models\User;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use App\Models\Image;
use App\Models\Auther;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles=[
            'author','user'
        ];
         Role::create(['name' => 'author']);

         Role::create(['name'=>'user']);
     

        Admin::create([
            'email'=>'admin@example.com',
            'password'=>Hash::make('password'),
        ]);
        User::factory(7)
        ->has(
            Image::factory()
                ->count(1)
                ->state(function (array $attributes, User $category) {
                    return ['type' => ''];
                })
        )->create()->each(function($user) use ($roles){
            $user->assignRole($roles[random_int(0,1)]);
        });
        
        Category::factory(8)->create();


            $book=Book::factory()->count(50)->hasImages(4,['type'=>'gallary'])

           ->hascoverImage(1,['type'=>'cover'])
           ->hasbookFile(1,[
            'type'=>'file',
            'file'=>'https://via.placeholder.com/600x600.pdf'
           ]);

           $book->create();
        
    }
}
