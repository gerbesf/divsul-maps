<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelsIndex extends Model
{

    public $table = 'levels_index';

    protected $fillable = [
        'map_key','size','game_mode','layout', 'players'
    ];

    protected $casts = [
       # 'Layouts'=>'array'
    ];

    public $timestamps = false;

    public function map(){
        return $this->hasOne('\App\Models\Levels','Key','map_key');
    }

}
