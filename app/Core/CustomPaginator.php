<?php

namespace App\Core;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomPaginator extends LengthAwarePaginator
{
   
    public function toArray()
    {
      return [
        'current_page' => $this->currentPage(),
        'data' => $this->items->toArray(),
        'last_page' => $this->lastPage(),
        'per_page' => $this->perPage(),
        'total' => $this->total(),
      ];
    }
}