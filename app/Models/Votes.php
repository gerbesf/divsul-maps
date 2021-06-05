<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'votemap',
        'layout',
        'players',
        'winner',
        'rotations_history',
        'expires_at',
    ];

    protected $casts = [
        'rotations_history' => 'array',
        'votemap' => 'array',
        'expires_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];

    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function map(){
        return $this->hasOne('App\Models\Levels','Name','winner');
    }

}
