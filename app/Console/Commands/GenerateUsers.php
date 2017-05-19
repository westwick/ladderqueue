<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GenerateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:generate {count} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate some users!';

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
        $count = $this->argument('count');
        $name = $this->argument('name');
        for($i = 1; $i <= $count; $i++) {
            $user = new User();
            $user->email = $name . $i;
            $user->name = $name . $i;
            $user->password = Hash::make('123123');
            $user->save();
        }
    }
}
