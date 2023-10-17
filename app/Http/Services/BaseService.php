<?php

namespace App\Http\Services;

use Error;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Services\SearchService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
