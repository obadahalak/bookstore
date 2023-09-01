<?php

use App\Models\BooksScheduling;
use Illuminate\Support\Facades\DB;


class BookScheduleService {


    public function index(){
        
    return DB::table('books_schedulings as b')
            ->where('user_id',auth()->id())
            ->join('scheduling_info as s','s.books_scheduling_id','b.id')
            ->join('books','books.id','b.book_id')
            ->select(
                'b.id as id',
                'books.name as book_name',
                'b.duration as duration',
                's.date as date',
                's.pages as pages',
                'b.created_at as started_task'

            )->get();
    }
    public function countOfCompletedPaegs(){
        $booksWithCompletedPages = BooksScheduling::withSum(['schedulingInfos as pages_completed' => function($q){
            $q->where('status', true);
         }], 'pages')
         ->get();
         
        return $booksWithCompletedPages->sum(function($q){
             return $q->pages_completed;
         });
 
    }

    public function booksInfo(){
        return BooksScheduling::query()
            ->selectRaw('COUNT(*) as all_books')
            ->selectRaw('COUNT(CASE WHEN STATUS = true THEN 1 ELSE null END) as books_completed')
            ->selectRaw('COUNT(CASE WHEN STATUS = false THEN 1 ELSE null END) as books_not_completed')
            ->first();
    }

    public static function schedulingFinesh($id){
        
        BooksScheduling::find($id)->update([
            'status'=>true,
        ]); 
    }
}