<?php

namespace App\Console\Commands;

use App\Models\Admins;
use App\Models\Server;
use App\Models\Servers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class ServerSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Server Sync';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $Server = Server::first();

      #  try {
            dispatch_now( new \App\Jobs\ServerSync( $Server->id ) );
       /* }catch (\Exception $exception){
            throw new Exception('Fatal error on ServerSync');
            /* Servers::where('id',$Server->id)->update([
                 'status'=>'error'
             ]);*/
       # }*/
    }
}
