<?php

namespace App\Http\Controllers\Api;

use App\Models\SchedulingInfo;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookSchedulingInfo;
use App\Http\Services\BookScheduleService;
use App\Http\Requests\BooksSchedulingRequest;
use App\Http\Services\baseQuery;
use App\Models\Book;

class BooksSchedulingController extends Controller
{
    public function __construct(private BookScheduleService $bookSchedule)
    {
    }

    public function store(BooksSchedulingRequest $reqeust)
    {
        $this->bookSchedule->create($reqeust->validatedDataScheduling(), $reqeust->validatedDataInfo());

        return response()->data(key: 'data', message: 'created successfully', code: 201);
    }

    public function index()
    {

        return baseQuery::buildQuery(
            Book::class,
            true,
            ['category:id,title,count_of_books', 'user:id,name', 'coverImage', 'bookFile'],
            [['column' => 'id', 'value' => 68], ['column' => 'name', 'value' => 'book-name']]
        );
    }

    public function staticses()
    {

        $completed_pages = $this->bookSchedule->countOfCompletedPaegs();
        $books_info = $this->bookSchedule->booksInfo();

        return response()->data(
            key: 'data',
            data: ['completed_pages' => $completed_pages, 'books_info' => $books_info]
        );
    }

    public function update(BookSchedulingInfo $request)
    {

        $schedule_info = SchedulingInfo::where('id', $request->validated('task_id'))->first();

        $schedule_info->update([
            'status' => true,
        ]);

        return response()->data(key: 'data', data: [], message: 'task completd successfully', code: 201);
    }
}
