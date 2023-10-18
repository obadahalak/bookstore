<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [];

    const COVER_TYPE="cover";
    
    const GALLARY_TYPE="cover";
    
    const FILE_TYPE="cover";
    /**
     * Get the parent imageable model (user or post).
     */
    public function imageable()
    {

        return $this->morphTo();
    }
}
