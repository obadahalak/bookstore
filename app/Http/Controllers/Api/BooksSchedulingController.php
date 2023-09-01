<?php

namespace App\Http\Controllers\Api;

use BookScheduleService;
use App\Models\SchedulingInfo;
use App\Models\BooksScheduling;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookSchedulingInfo;
use App\Http\Requests\BooksSchedulingRequest;
use App\Http\Resources\BooksSchedulingResourse;

class BooksSchedulingController extends Controller
{
    public function __construct(private BookScheduleService $bookSchedule){}
    public function store(BooksSchedulingRequest $reqeust)
    {       
        
        $bookSchudling=BooksScheduling::create($reqeust->validatedDataScheduling());
        
        foreach( $reqeust->validatedDataInfo() as $info){
            
            $bookSchudling->schedulingInfos()->create([
                'pages'=>$info['pages'],
                'date'=>$info['date'],
               'status'=>$info['status'],
            ]);
        }
    
            return response()->data(key:'data',message:'created successfully',code:201);
    }
    public function index(){          
        return  BooksSchedulingResourse::collection($this->bookSchedule->index());
    }

    public function staticses()
    {   

        $completed_pages=$this->bookSchedule->countOfCompletedPaegs();
        $books_info=$this->bookSchedule->booksInfo();
        
        return response()->data(
            key:"data",
            data:['completed_pages'=>$completed_pages,'books_info'=>$books_info]
        );        
    }

    public function update(BookSchedulingInfo $request){
        
         $schedule_info=SchedulingInfo::where('id',$request->validated('task_id'))->first();
      
         $schedule_info ->update([
            'status'=>true
         ]);
        
         return response()->data(key:"data",data:[],message:"task completd successfully",code:201);
    }
}
