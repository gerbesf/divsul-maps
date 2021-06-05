<?php

namespace Database\Seeders;

use App\Models\Levels;
use Illuminate\Database\Seeder;

class Filters extends Seeder
{

    protected $size_names = [
        '16' => 'Infantry',
        '64' => 'Standard',
        '32' => 'Alternative',
        '128' => 'Large',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->FilterLayouts();

        $scope = [
            'name' => 'Players',
            'settings' => array([
                'name' => '0 - 30',
                'code' => '0_30'
            ],[
                'name' => '31 - 40',
                'code' => '31_40'
            ],[
                'name' => '41 - 60',
                'code' => '41_60'
            ],[
                'name' => '61 - 80',
                'code' => '61_80'
            ],[
                'name' => '81 - 100',
                'code' => '81_100'
            ])
        ];

        if(\App\Models\Filters::where('name','Players')->count()==0){
            \App\Models\Filters::firstOrCreate($scope);
        }else{
            $get = \App\Models\Filters::where('name','Players')->first();
            \App\Models\Filters::where('id',$get->id)->update($scope);
        }

    }

    protected function FilterLayouts(){
        $Levels = Levels::get();
        $result = [];
        foreach($Levels as $level){
            foreach($level->Layouts as $layout){

                $nKey = str_replace('gpm_','',$layout['Key']);
                $nVal = $layout['Value'];
                if(!isset($result[ $nKey ]) && $nKey!='coop')
                    $result[ $nKey ]= $nKey;
            }
        }
        $settings_block = [];
        foreach($result as $code){
            $settings_block[] = [
                'name' => $code,
                'code' => $code
             #   'code' => __('app.'.$code)
            ];
        }
        $scope = [
            'name' => 'Layout',
            'settings'=>$settings_block
        ];
      #  dd($scope);
        if(\App\Models\Filters::where('name','Layout')->count()==0){
            \App\Models\Filters::firstOrCreate($scope);
        }else{
            $get = \App\Models\Filters::where('name','Layout')->first();
            \App\Models\Filters::where('id',$get->id)->update($scope);
        }

    }

    protected function FilterMods(){
        $scope = [
            'name' => 'Mods',
            'settings' => array([
                'name' => 'Vietnam',
                'code' => 'vietnam'
            ],[
                'name' => 'ww2',
                'code' => 'WW2'
            ])
        ];


        if(\App\Models\Filters::where('name','Mods')->count()==0){
            \App\Models\Filters::firstOrCreate($scope);
        }else{
            $get = \App\Models\Filters::where('name','Mods')->first();
            \App\Models\Filters::where('id',$get->id)->update($scope);
        }

    }
}
