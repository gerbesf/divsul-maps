<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Online extends Model
{

    public $table = 'online';

    protected $fillable = [
        'profile_id',
        'tag',
        'nick',
        'team',
        'deaths',
        'kills',
        'score',
        'valid',
        'tags',
        'nicks',
        'ips',
        'banned'
    ];

    protected $casts = [
        'tags'=>'array',
        'nicks'=>'array',
        'ips'=>'array',
    ];

    public $timestamps = false;
}
