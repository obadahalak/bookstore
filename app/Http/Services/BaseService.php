<?php

namespace App\Http\Services;

class BaseService 
{
    protected $model;
    // protected
    public function __construct($model)
    {
        $this->model = $model;
    }

 
    // function all(): array;

    // function filter(): array;

    // function create(array $request, null $args): void;

    // function update(int $id, null $args): bool;

    // function delete(int $id, null $args): bool;
}
