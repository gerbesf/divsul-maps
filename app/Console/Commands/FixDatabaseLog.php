<?php

namespace App\Console\Commands;

use App\Models\Levels;
use App\Models\ServerHistory;
use Illuminate\Console\Command;

class FixDatabaseLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Divsul Fix Logs';

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
        $Logs = ServerHistory::get();
        foreach($Logs as $item){
            $Level = Levels::where('name',$item->name)->first();

            if(isset($Level->Key)){
                ServerHistory::where('id',$item['id'])->update([
                    'map_key'=>$Level->Key
                ]);
            }

        }
    }
}
