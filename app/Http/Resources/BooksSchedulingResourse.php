<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BooksSchedulingResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $todayName = Carbon::today()->dayName;
        $status_of_day = isset($this->days->$todayName) ? $this->days->$todayName->status  : 'no task today';


        return [
            'id' => $this->id,
            'book_name' => $this->book->name,
            'pages_must_be_read' => $this->pages_per_day,
            'started_task' => $this->created_at->longRelativeToNowDiffForHumans(),
            'duration' => $this->checkDurationTaks($this->created_at->addDays($this->duration)),
            'general_duration' => $this->duration . ' ' . 'days',
            'today' => $status_of_day,
        ];
    }
}
