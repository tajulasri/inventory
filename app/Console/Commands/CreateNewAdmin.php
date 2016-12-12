<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class CreateNewAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {username} {password} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new admin ';

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
     * @return mixed
     */
    public function handle()
    {
        $user = new User();
        $user->name = $this->argument('username');
        $user->email = $this->argument('username');
        $user->password = bcrypt($this->argument('password'));
        $user->save();
        $this->info('new admin created');
    }
}
