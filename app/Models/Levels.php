<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Levels extends Model
{

    public $table = 'levels';

    protected $fillable = [
        'Name','Key', 'Resolution', 'Size', 'Color','Layouts','Slug','Image',
    ];

    protected $casts = [
        'Layouts'=>'array'
    ];

    public function getImageKeyName(  ){
        if($this->Slug=='routee106'){
            return 'routee-106';
        }elseif($this->Slug=='musaqalabeta'){
            return 'musaqala-beta';
        }elseif($this->Slug=='fieldsofkasselbeta'){
            return 'fieldsofkassel-beta';
        }elseif($this->Slug=='masirahbeta'){
            return 'masirah';
        }elseif($this->Slug=='adakbeta'){
            return 'adak-beta';
        }elseif($this->Slug=='operationthunderbeta'){
            return 'operationthunder-beta';
        }elseif($this->Slug=='masirahbeta'){
            return 'masirah-beta';
        }elseif($this->Slug=='operationbobcatbeta'){
            return 'operationbobcat';
        }elseif($this->Slug=='hibernaseasonal'){
            return 'hiberna-seasonal';
        }elseif($this->Slug=='iceboundseasonal'){
            return 'icebound-seasonal';
        }else{
            return $this->Slug;
        }
    }

    public $timestamps = false;
}
