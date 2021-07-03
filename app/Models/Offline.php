<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offline extends Model
{

    public $table = 'offline';

    protected $fillable = [
        'nick',
        'object',
    ];

    protected $casts = [
        'object'=>'array'
    ];

    public $timestamps = false;
}
