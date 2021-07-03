<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clans extends Model
{

    public $table = 'clans';

    protected $fillable = [
        'name',
        'tag',
    ];

    protected $casts = [
    ];

    public $timestamps = false;
}
