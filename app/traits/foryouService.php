<?php

namespace App\traits;

use App\Models\UserActivity;
use Illuminate\Support\Facades\DB;

trait foryouService
{
    public function getCategoirsFromWishList()
    {
        return DB::table('likes')
            ->where('likes.user_id', auth('user')->id())

            ->join('books', 'books.id', '=', 'likes.book_id')

            ->selectRaw('books.category_id, COUNT(likes.id) AS num_likes')

            ->groupBy('books.category_id')

            ->orderBy('num_likes', 'DESC')

            ->pluck('category_id')

            ->take(5)->toArray();
    }

    public function sortingIds($categories)
    {
        return array_unique(array_merge(UserActivity::getBooksCategories(), $categories));
    }
}
