<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\AdminMaster;
use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{

    protected $signature = 'create:admin_master {name} {nick} {email} {password}';

    protected $description = 'Create Administrative Administrators';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        // arguments
        $name = $this->argument('name');
        $password = $this->argument('password');
        $email = $this->argument('email');

        // Create
        User::create([
            'name' => $name,
            'nickname' => $name,
            'email' => $email,
            'level' => 'M',
            'password' => app('hash')->make($password),
            'created_at' => date_create()->format('Y-m-d H:i:s'),
            'updated_at' => date_create()->format('Y-m-d H:i:s'),
        ]);
        $this->info('Account created for '.$name);

    }

}
