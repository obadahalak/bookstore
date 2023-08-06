<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function store(CategoryRequest $request){
        Category::cretae(['name'=>$request->name]);
        return response()->data('category created successfully',201);
    }
    public function categories(){   

   
        return response()->cacheResponsePaginate(CategoryResource::collection(Category::paginate(10))); 
 
    } 

}
