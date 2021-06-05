<?php

namespace App\Console\Commands;

use App\Models\Levels;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Ixudra\Curl\Facades\Curl;

class RealityMaps extends Command
{

    protected $signature = 'reality:maps';

    protected $description = 'Sync maps of reality mod';

    protected $api_reality = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $this->requestApi();
        foreach($this->api_reality as $item){
            $array_object = collect($item)->toArray();
            $payload = $this->getExtraData($array_object);
            #dd($payload);
            if( Levels::where('Slug',$payload['Slug'])->count() == 0){
                $Entity = new Levels( $payload );
                $Entity->save();
            }else{
                Levels::where('Slug',$payload['Slug'])->update($payload);
            }

        }

    }

    protected function requestApi(){

        $endpoint = 'https://www.realitymod.com/mapgallery/json/levels.json';
        $this->api_reality = Curl::to( $endpoint )
            ->asJson()
            ->get();

    }

    protected function getExtraData( $array_object ){
        if(  count(explode(' - ',$array_object['Name'])) == 2){
            $name=str_replace(' ','',strtolower($array_object['Name']));
        }else{
            $name=str_replace('-','',\Illuminate\Support\Str::slug($array_object['Name']));
        }
        $array_object['Slug'] = str_replace(['-','_'],'',$name);
        $array_object['Image'] = $this->getImageKeyName($array_object['Slug']);
        $array_object['Layouts'] = collect($array_object['Layouts'])->map(function ($obj){
          #  if($obj->Key!="gpm_coop"){
                $obj->Key=str_replace('gpm_','',$obj->Key);
                return $obj;
          #  }
        })->sortBy('Key' );
       # dd($array_object['Layouts']);
        return $array_object;
    }


    public function getImageKeyName( $slug ){
        if($slug=='routee106'){
            return 'routee-106';
        }elseif($slug=='musaqalabeta'){
            return 'musaqala-beta';
        }elseif($slug=='adakbeta'){
            return 'adak-beta';
        }elseif($slug=='operationthunderbeta'){
            return 'operationthunder-beta';
        }elseif($slug=='masirahbeta'){
            return 'masirah-beta';
        }elseif($slug=='operationbobcatbeta'){
            return 'operationbobcat-beta';
        }elseif($slug=='hibernaseasonal'){
            return 'hiberna-seasonal';
        }elseif($slug=='iceboundseasonal'){
            return 'icebound-seasonal';
        }else{
            return $slug;
        }
    }

}
