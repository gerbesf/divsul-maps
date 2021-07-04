<?php

namespace App\Http\Livewire;

use App\Models\Clans;
use App\Models\Offline;
use App\Models\Online;
use App\Models\Profiles;
use Illuminate\Support\Facades\Cache;
use Ixudra\Curl\Facades\Curl;
use Livewire\Component;

class PlayersOnline extends Component
{

    public $groupTeams = true;
    public $highOnly = false;
    public $selectedClan = null;

    public $clans = [];
    public $players = [];

    public $profile = [];
    public $find_hash = [];
    public $find_ip = [];



    #public $results = [];

    public function mount(){
    #    $query  = Online::get();
       # $this->clansOptions( $query );
    }#

    public function clansOptions($query){
     /*   foreach($query as $item){
            if($item->tag){
                $this->clans[$item->tag] =$item->tag;
            }
            $this->players[] = $item->nick;
        }*/
    }


    function objectToArray($objectOrArray) {
        // if is_json -> decode :
        if (is_string($objectOrArray)) $objectOrArray = @json_decode($objectOrArray) ?: $objectOrArray;

        // if object -> convert to array :
        if (is_object($objectOrArray)) $objectOrArray = (array) $objectOrArray;

        // if not array -> just return it (probably string or number) :
        if (!is_array($objectOrArray)) return $objectOrArray;

        // if empty array -> return [] :
        if (count($objectOrArray) == 0) return [];

        // repeat tasks for each item :
        $output = [];
        foreach ($objectOrArray as $key => $o_a) {
            $output[$key] = $this->objectToArray($o_a);
        }
        return $output;
    }

    protected $hash_search = 'http://braserver.divsul.org:666/PRServer/LogViewer/public/get_player.php?server_id=1,&group_by=hash&hide=true&search=';
    protected $ip_search = 'http://braserver.divsul.org:666/PRServer/LogViewer/public/get_player.php?server_id=1,&group_by=nick&hide=true&search=';

    public function backt(){
        $this->profile = [];
        $this->find_hash = [];
        $this->find_ip = [];
    }
    public function viewProfile( $id ){
        $Profile = Profiles::where('id',$id)->first();
        $this->profile = $Profile->toArray();

        $hash = $Profile->hash;
        $content = Cache::remember($id.'id',400,function () use ( $hash ) {
            return Curl::to($this->hash_search.trim($hash))
                ->asJson()
                ->get();
        });

        $content = $this->objectToArray($content);
        $this->find_hash = $content;

        $ip = null;
        foreach($content as $hash => $blockList){
            if($hash==$Profile->hash){
                if(!$ip){
                    $ip = $blockList[array_key_first($blockList)]['ip'];
                }
            }
        }

        $contentx = Cache::remember($id.'ip',400,function () use ( $ip ) {
            return Curl::to($this->hash_search.trim($ip))
                ->asJson()
                ->get();
        });
        $contentx = $this->objectToArray($contentx);
        $this->find_ip = $contentx;

    }

    public function makeView(){
        $query  = Online::get();
        $results = [];
        if($this->groupTeams==false){
            foreach($query as $item){
                $results[] = $item->toArray();
            }
        }else{
            foreach($query as $item){
                $results[$item->team][] = $item->toArray();
            }
        }
        return $results;
    }

    public function render()
    {
        return view('livewire.players-online',[
            'offline'=>Offline::get(),
            'results'=>Online::orderBy('score','desc')->get()
        ]);
    }
}
