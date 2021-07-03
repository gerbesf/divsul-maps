<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{

    public $table = 'messages';

    protected $fillable = [
        'payload',
        'created_at',
    ];

    protected $casts = [
        'payload'=>'array',
        'created_at'=>'timestamp',
    ];

    public $timestamps = false;
}
