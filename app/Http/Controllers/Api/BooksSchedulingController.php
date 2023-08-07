<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BooksSchedulingRequest;
use App\Http\Resources\BooksSchedulingResourse;
use App\Models\BooksScheduling;
use Carbon\Carbon;

class BooksSchedulingController extends Controller
{
    public function store(BooksSchedulingRequest $reqeust)
    {
        return  BooksScheduling::create($reqeust->validatedData());
    }
    public function index()
    {

        return BooksSchedulingResourse::collection(BooksScheduling::where('user_id', auth()->id())->get());
    }
}
