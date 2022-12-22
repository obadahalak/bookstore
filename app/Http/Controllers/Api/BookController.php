<?php


namespace App\Http\Controllers\Api;


use  App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function books(){
        return book::all();
    }
}
