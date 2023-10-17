<?php

namespace App\Http\Resources;

use App\Models\BooksScheduling;
use Carbon\Carbon;
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

        $startdTask = Carbon::parse($this->started_task);

        $date = Carbon::parse($this->date);
        $status_of_day = ($date->format('Y-m-d') == now()->format('Y-m-d')) ? 1 : 0;

        return [
            'id' => $this->id,
            'book_name' => $this->book_name,
            'pages_must_be_read' => $this->pages,
            'started_task' => $startdTask->longRelativeToNowDiffForHumans(),
            'duration' => BooksScheduling::checkDurationTask($startdTask->addDays($this->duration)),
            'general_duration' => $this->duration . ' ' . 'days',
            'today' => $status_of_day,
        ];
    }
}
