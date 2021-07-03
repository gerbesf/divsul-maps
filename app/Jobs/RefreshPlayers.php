<?php

namespace App\Jobs;

use App\Models\Clans;
use App\Models\Offline;
use App\Models\Online;
use App\Models\Profiles;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Ixudra\Curl\Facades\Curl;

class RefreshPlayers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $player_search = 'http://braserver.divsul.org:666/PRServer/LogViewer/public/get_player.php?server_id=1,&group_by=nick&hide=true&search=';
    protected $hash_search = 'http://braserver.divsul.org:666/PRServer/LogViewer/public/get_player.php?server_id=1,&group_by=hash&hide=true&search=';
    protected $ip_search = 'http://braserver.divsul.org:666/PRServer/LogViewer/public/get_player.php?server_id=1,&group_by=nick&hide=true&search=';
    protected $players;

    public $banned;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $players )
    {
        $this->players = $players;
    }

    protected function getClan( $tag ){
        $ClanCount = Clans::where('tag',$tag)->count();
        if($ClanCount==0){
            $clan = Clans::create([
                'name' => $tag,
                'tag' => $tag,
                'valid'=>false
            ]);
        }else{
            $clan = Clans::where('tag',$tag)->first();
        }
        if($ClanCount>=2 && $clan->valid!=true){
            Clans::where('tag',$tag)->update([
                'valid'=>true
            ]);
        }
        return $clan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $online = [];
        $offline = [];
        $array = [];

        foreach($this->players as $player){


            $nick = trim($player->name);
            $explodeNick = explode(' ',$nick);

            // Sem Clan
            if(count($explodeNick)==1){
                $tag = null;
            }

            if(count($explodeNick)==2){
                $tag = $explodeNick[0];
                unset($explodeNick[0]);
                $nick = implode(' ',$explodeNick);
            }

            $Profile = Profiles::where('nickname',$nick)->first();

            if($tag){

                $Clan = $this->getClan($tag);
                if($Profile && !$Profile->id_clan && $Clan){
                    $Profile->id_clan = $Clan->id;
                    $Profile->save();
                }

            }

            if($Profile){

                echo date('H:i:s').' -- '.$nick.PHP_EOL;

                $tags = $this->getTags($Profile,$nick);
                $nicks = [];

                /*if(in_array('high_risk',$tags)){
                }*/

                $this->banned = false;

                $nicks = $this->findHashDuplicated($nick,$Profile->hash);

                $ipmaldito = $this->findHashIP_Duplicated($nick,$Profile->hash);

                if($this->banned){
                    echo ' -- BANNED --'.PHP_EOL;
                }

                $array[] = [
                    #'hash'=>$Profile->hash,
                    'profile_id'=>$Profile->id,
                    #'clan_id'=> @$Clan->id ?: null,
                    'team'=>$player->team,
                    'kills'=>$player->kills,
                    'deaths'=>$player->deaths,
                    'score'=>$player->score,
                    'tag'=>$tag,
                    'nick'=>$nick,
                    'tags'=>$tags,
                    'nicks'=>$nicks,
                    'ips'=>$ipmaldito,
                    'banned'=>$this->banned
                ];

            }else{
                $offline[] = $player;
                echo date('H:i:s').' --- ('.$player->name.') -- NOT FOUND IN DATABASE'.PHP_EOL;
            }

        }

        $this->reSync($array,$offline);

        echo ' -- TERMINOU -- ';
       # dd('Terminou');
    }

    protected function reSync($online,$offline){
        Online::where([])->delete();
        Offline::where([])->delete();
        foreach($offline as $off){
            Offline::create([
                'nick'=>$off->name,
                'object'=>$off
            ]);
        }
        foreach($online as $on){
            Online::create($on);
        }
    }

    public function getTags($profile,$nick){

        $content = Curl::to($this->player_search.trim($nick))
            ->asJson()
            ->get();

        $content = $this->objectToArray($content);

        $tags = [];

        foreach($content as $lNickname=>$objectList){

            if($lNickname==$nick){

                $linha = $objectList[ array_key_last($objectList)];

                if($linha['whitelisted']){
                    $tags[] = 'whitelisted';
                }

                if($linha['banned']){
                    $tags[] = 'banned';
                }

                if($linha['steam_level']==0){
                    $tags[] = 'high_risk';
                }
                if($linha['steam_level']==1){
                    $tags[] = 'medium_risk';
                }
                if($linha['steam_level']==2){
                    $tags[] = 'low_risk';
                }

                if(in_array('LEGACY',$linha['tags'])){
                    $tags[] = 'legacy';
                }
                if(in_array('WHITELISTED',$linha['tags'])){
                    $tags[] = 'whitelist';
                }
                if(in_array('VAC BANNED',$linha['tags'])){
                    $tags[] = 'VAC';
                }

                if($profile->hash!=$linha['hash']){
                    $tags[] = 'DIFF-HASH';
                }



            }

        }

        return $tags;

    }

    public function findHashIP_Duplicated( $nick, $hash )
    {

        $content = Cache::remember($nick.'sIPx', 400, function () use ($hash) {
            return Curl::to($this->ip_search . trim($hash))
                ->asJson()
                ->get();
        });

        $content = $this->objectToArray($content);

        if(count($content)>=2){

            $nicks = [];
            foreach($content as $key=>$objs){
                foreach($objs as $item){
                    if($item['banned'] or in_array('VAC BANNED',$item['tags'])){
                        $this->banned=true;
                    }
                    $nicks[$item['nick']] = $item['nick'];
                }
            }

            return $nicks;
        }

        return [];
    }

    public function findHashDuplicated( $nick, $hash ){

        $content = Cache::remember($nick.'q',400,function () use ( $hash ) {
            return Curl::to($this->hash_search.trim($hash))
                ->asJson()
                ->get();
        });

        $content = $this->objectToArray($content);

        $nicks = [];

        foreach($content as $hash=>$block){
            foreach($block as $linha_block){
                if($nick!=$linha_block['nick']){
                    if($linha_block['banned'] or in_array('VAC BANNED',$linha_block['tags'])){
                        $this->banned=true;
                    }
                    $nicks[$linha_block['nick']]=$linha_block['nick'];
                }
            }
        }

        return $nicks;
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
}
