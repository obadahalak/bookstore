<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

function generateToken()
{
    $str = random_bytes(20);

    return bin2hex($str);
}
