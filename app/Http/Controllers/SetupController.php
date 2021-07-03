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

    /**
     * Setup Page
     */
    public function setup(Request $request ){

        if(Auth::user()->level!="M")
            return redirect('/');

        if($request->has('id')){
            $this->changeServer($request);
        }

        $this->populateServers();

        $Server = Server::first();

        return view('setup',[
            'servers'=>$this->api_reality_servers,
            'server'=>$Server
        ]);
    }

    /**
     * Change Server
     */
    public function changeServer( Request $request ){

        $this->populateServers();
        foreach($this->api_reality_servers as $server) {

            Server::where([])->delete();

            if( $server->serverId==$request->get('id')){

                Server::create([
                    'server_id' => $server->serverId,
                    'name' => $this->getServerName( $server),
                    'status' => 'active'
                ]);

                Artisan::call('reality:maps');

                // return
                return redirect('/maps');

            }

        }

    }


    /**
     * Populate Servers
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

    public function update(){
        $Server = Server::first();
        Server::where('id',$Server->id)->update([
            'hash_endpoint' => request()->get('hash_endpoint'),
            'http_username' => request()->get('http_username'),
            'http_password' => request()->get('http_password'),
        ]);
        return redirect('/setup');
    }

}
