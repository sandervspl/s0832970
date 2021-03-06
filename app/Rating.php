<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'image_id',
        'rating_id',
        'user_id',
        'created_at',
        'updated_at'
    ];
}
