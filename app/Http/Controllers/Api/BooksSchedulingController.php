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
            BooksScheduling::create($reqeust->validatedData());
            return response()->data(key:'data',message:'created successfully',code:201);
    }
    public function index()
    {

        return  BooksSchedulingResourse::collection(BooksScheduling::with(['user', 'book'])->paginate(10));
    }

    public function staticses()
    {
        $pages =     BooksScheduling::get()->flatMap(function ($value) {
            $readed_pages = array();

            foreach ($value->days as $days) {
                if ($days->status === true) {
                    array_push($readed_pages, $value->pages_per_day);
                }
            }
            return  $readed_pages;
        })->toArray();
        $completed = array_sum($pages);

        return response()->data(['readed_pages' => $completed]);
    }
    
    public function send_notify(){
        $array=[];
        foreach(BooksScheduling::get() as $key => $days){

            $array[$key]['user_id']=$days->user_id;  
            
            $array[$key]['book_id']=$days->user_id;  
            $array[$key]['data']=[];

            foreach($days->days as  $date){
                if($date->status==false)  
                    array_push($array[$key]['data'],$date->date);
                }  
        }
        return  $array;

    }
}
