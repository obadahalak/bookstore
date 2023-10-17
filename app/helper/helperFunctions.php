<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;


function generate_token()
{
    $str = random_bytes(20);

    return bin2hex($str);
}


function  columnList($model)
{
    if ($model instanceof Model) {
        return Schema::getColumnListing((  $model)->getTable());
    }
}


// $tableName = (new $model)->getTable();

// $columns = Schema::getColumnListing($tableName);

// $columnTypes = [];

// foreach ($columns as $column) {
//     $columnType = Schema::getColumnType($tableName, $column);
//     $columnTypes[$column] = $columnType;
// }
// return $columnTypes;
// 