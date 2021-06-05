<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Ixudra\Curl\Facades\Curl;
use Cache;
use Illuminate\Support\Facades\Auth;


class SetupController extends Controller
{

    public $api_reality_servers;

    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function setup(Request $request ){

        if(Auth::user()->level!="M")
            return redirect('/');

        if($request->has('id')){
            $this->changeServer($request);
        }


        $this->populateServers();

        return view('setup',[
            'servers'=>$this->api_reality_servers
        ]);
    }

    public function changeServer( Request $request ){

        $this->populateServers();
        foreach($this->api_reality_servers as $server) {

            Server::where([])->delete();

            if( $server->serverId==$request->get('id')){

              #  if( Server::count() == 0 ) {

                    Server::create([
                        'server_id' => $server->serverId,
                        'name' => $this->getServerName( $server),
                        'status' => 'active'
                    ]);
/*
                }else{

                    // Update current entity
                    $ServerEntity = Server::first();
                    Server::where('server_id',$ServerEntity->serverId)->update([
                        'server_id' => $server->serverId,
                        'name' => $this->getServerName( $server),
                        'status' => 'active'
                    ]);
                }*/

                Artisan::call('reality:maps');

                // return
                return redirect('/maps');


            }

        }

    }

    /**
     * Get Server Name
     * Remover server settings from name
     *
     * @param $server
     * @return string
     */
    protected function getServerName( $server ){
        $hostname = $server->properties->hostname;
        $_ihostname = explode(' ',$hostname);
        unset($_ihostname[0]);
        unset($_ihostname[1]);
        return implode(' ',$_ihostname);
    }

}
