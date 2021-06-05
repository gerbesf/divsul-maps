<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{

    public $table = 'server';

    protected $fillable = [
        'name', 'server_id', 'status',
    ];

    public $timestamps = false;
}
