<?php

namespace App\Console\Commands;

use App\Jobs\DiscordMessage;
use App\Models\Levels;
use App\Models\ServerHistory;
use Cache;
use App\Models\Server;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Ixudra\Curl\Facades\Curl;

class RealityServer extends Command
{

    protected $signature = 'reality:server';

    protected $description = 'Sync server on reality mod';

    protected $api_reality_servers = [];

    protected $level = '';
    protected $hostname = '';
    protected $gamever = '';
    protected $mapname = '';
    protected $gametype = '';
    protected $mapsize = '';
    protected $numplayers = '';
    protected $maxplayers = '';
    protected $flag_county = '';

    protected $last_entity;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->populateServers();
        $this->configureServer();

        $name = (str_replace("'",'',$this->mapname));
        $slug = strtolower(str_replace(['_','-',' ',"'"],'',$this->mapname));
        $this->last_entity = ServerHistory::orderBy('id','desc')->first();


        if($name) {

            $Level = Levels::where('name',$name)->first();

            $valid = false;
            if($this->numplayers>=env('DIV_MIN_PLAY_VALID')){
                $valid = true;
            }


            // If not exists entity
            if (!isset($this->last_entity->id)) {

                // payload
                $payload = [
                    'name' => $name,
                    'map_key' => $Level->Key,
                    'map_mode' => str_replace('gpm_', '', $this->gametype),
                    'map_size' => $this->mapsize,
                    'timestamp' => Carbon::now(),
                    'players' => $this->numplayers,
                    'valid' => $valid
                ];

                // Create
                ServerHistory::create($payload);
            }

            // if Entity is diff from last
            if (isset($this->last_entity->id)) {

               # dd($this->last_entity->map_key , $Level->Key);
                if ($this->last_entity->map_key != $Level->Key) {

                    // select map
                   # $map = Levels::where('Slug',$slug)->first();

                    // image
                    $game_mode = str_replace('gpm_', '', $this->gametype);
                    $image = 'https://www.realitymod.com/mapgallery/images/maps/'.$Level->Image.'/mapoverview_gpm_'.$game_mode.'_'.$this->mapsize.'.jpg';

                    $name .= ' - '.__('app.'.str_replace('gpm_', '', $this->gametype)).' - '.__('app.sized_'.$this->mapsize);

                    // payload
                    $payload = [
                        'name' => $name,
                        'map_key' => $Level->Key,
                        'map_mode' => str_replace('gpm_', '', $this->gametype),
                        'map_size' => $this->mapsize,
                        'timestamp' => Carbon::now(),
                        'players' => $this->numplayers,
                        'valid' => $valid
                    ];

                    #dd($payload);
                    // Discord Alert
                    dispatch( new DiscordMessage( 'primary', $name, $this->numplayers.'/100',  [
                        'image'=>$image
                    ]));

                    // Create
                    ServerHistory::create($payload);
                }else{

                    // Check validatit
                    $this->checkIsValidNow( $valid );

                }
            }
        }
    }

    protected function checkIsValidNow( $valid){


        // for update total players
        $payload = [];
        $payload['players'] = $this->numplayers;

        if(isset($this->last_entity->valid)){

            $payload['valid'] = $valid;
            ServerHistory::where('id',$this->last_entity->id)->update($payload);
        }
    }

    /**
     * Populate Pr Servers
     * @todo general class
     * @throws \Exception
     */
    protected function populateServers() {
        $response = Cache::remember('prspy',60,function (){
            return Curl::to('https://servers.realitymod.com/api/ServerInfo')
                ->asJson()->get();
        });
        if( isset($response->servers)){
            $this->api_reality_servers = $response->servers;
            sort($this->api_reality_servers);
        }else{
            throw new \Exception('Error on RealityMod / Servers Info');
        }
    }

    protected function configureServer(){

        $activeServer = Server::first();
        foreach($this->api_reality_servers as $server){

            if($server->serverId==$activeServer->server_id){

                // select level
                $Level = Levels::where('name',$server->properties->mapname)->first();
                $this->level = $Level;

                // server properties
                $gVer = explode('-',$server->properties->gamever);
                $this->hostname = substr($server->properties->hostname,14,99999);
                $this->gamever = $gVer[0];
                $this->mapname = $server->properties->mapname;
                $this->gametype = $server->properties->gametype;
                $this->mapsize = $server->properties->bf2_mapsize;
                $this->numplayers = $server->properties->numplayers;
                $this->maxplayers = $server->properties->maxplayers;
                $this->flag_county = $server->countryFlag;

            }
        }

    }

}
