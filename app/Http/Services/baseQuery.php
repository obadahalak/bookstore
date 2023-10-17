<?php

namespace App\Http\Services;

use Error;

class baseQuery
{

    public static  $model;

    public static function initial($model)
    {
        self::$model = new $model;
    }

    public static function buildQuery($model, Bool $whereAuthUser = false, array $relations = [], array $filter = [], $sortBy = 'id', $directionSort = 'asc')
    {

        self::initial($model);
        $query = self::$model;

        $query =  (!empty($relations)) ? $query->with($relations) : $query;

        $query = ($whereAuthUser) ? $query->where('user_id', auth()->id()) : $query;

        $query = self::search($query, $filter);

        $query = $query->orderBy($sortBy, $directionSort);

        return $query;
    }


    public static function search($query, $columns)
    {

        $query;
        if (!self::isNotabibiltyToSearch($columns)) {

            foreach ($columns as $value)
                $query = $query->orWhere($value['column'], $value['value']);

            return $query;
        }
    }

    public static function isNotabibiltyToSearch($columns)
    {
        $columns = (collect($columns))->pluck('column')->toArray();

        $diff = array_diff($columns, self::$model::$searchable);
        if ($diff) {

            // keys that not able to search it
            $column = implode(',', array_values($diff));
            throw new Error("these columns can`t searchit: $column ");
        }
        return false;
    }
}
