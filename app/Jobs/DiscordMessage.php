<?php

namespace App\Jobs;

use App\Models\ServerHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Woeler\DiscordPhp\Message\DiscordEmbedMessage;
use Woeler\DiscordPhp\Webhook\DiscordWebhook;

class DiscordMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $nickname;
    public $message;
    public $payload;
    public $color;

    public $colors =[
        'success' => 3066993,
        'primary' => 10181046,
        'warning' => 15844367,
        'error' => 15158332
    ];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $color, $nickname, $message, $payload = [])
    {
        $this->color = $color;
        $this->nickname = $nickname;
        $this->message = $message;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $message = (new DiscordEmbedMessage())
            #    ->setContent('PYSPY - '.$this->mapname)
            ->setAvatar(env('BOT_AVATAR'))
            ->setUsername(env('BOT_NAME') )
            ->setTitle($this->nickname);

        // Winner Map
        if( isset($this->payload['winner'])){
            $message->setTitle($this->nickname.' '.$this->message);
            $this->message = $this->payload['winner']->map->Name.' - '.__('app.'.$this->payload['winner']->game_mode).'  - '.__('app.sized_'.$this->payload['winner']['size']);
            $message->setImage('https://www.realitymod.com/mapgallery/images/maps/'.$this->payload['winner']->map->Image.'/mapoverview_gpm_'.$this->payload['winner']->game_mode.'_'.$this->payload['winner']->size.'.jpg');
            $message->setColor( 3066993);
        }
        if($this->color=='primary'){
            $message->setColor( $this->colors['primary']);
        }

        // Votemap Options
        if( isset($this->payload['image'])){
            $message->setImage($this->payload['image']);
        }
        // Votemap Options
        if( isset($this->payload['votemap'])){
            $i=1;
            foreach($this->payload['votemap'] as $map){
                $message->addField('#'.$i, $map['map']['Name'],true);
                $i++;
            }
        }

        // History on Votemap
        if( isset($this->payload['history']) && is_array($this->payload['history'])){

            $extra = '';
            foreach($this->payload['history'] as $map){
                $extra .= implode(' | ',$map)."\n";
            }

            if(strlen($extra)){
                $extra = "\n\nTentativas anteriores: \n";
                $message->setFooterText($extra);
            }
        }

        $message->setDescription($this->message);

        $webhook = new DiscordWebhook( env('DSC_MAP') );
        $webhook->send($message);
    }
}
