<?php

namespace App\Http\Controllers\Api;

use  App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TagResource;
use App\Models\Category;
use App\Models\Tag;

class CategoryController extends Controller
{

    public function tags()
    {
        return TagResource::collection(Tag::latest()->paginate(10));
    }
    public function categories()
    {
        return CategoryResource::collection(Category::with('tag')->latest()->paginate(10));
    }

    public function categoriesByTag($tagid)
    {

        return CategoryResource::collection(Category::where('tag_id', $tagid)->paginate(10));
    }
}
