<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiClone extends Model
{

    public $table = 'api_clone';

    protected $fillable = [
        'content',
    ];

    protected $casts = [
        'content'=>'array'
    ];

    public $timestamps = true;
}
