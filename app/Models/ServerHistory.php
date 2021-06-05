<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerHistory extends Model
{

    public $table = 'server_history';

    protected $fillable = [
        'name', 'map_key', 'map_mode','map_size','timestamp','players','valid'
    ];

    public $timestamps = false;

    public $casts = [
        'valid' => 'boolean'
    ];

    public function map(){
        return $this->hasOne('\App\Models\Levels','Name','name');
    }

}
