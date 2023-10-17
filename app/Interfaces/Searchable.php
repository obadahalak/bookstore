<?php

namespace App\Interfaces;

interface Searchable
{
    public function search($model, $columns);
}
