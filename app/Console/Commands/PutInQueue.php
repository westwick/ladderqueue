<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class PutInQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:putinq {count} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            $user = User::where('name', $name . $i)->first();
            if(!$user->joinQueue()) {
                $this->line('already in queue');
            } else {
                $this->line('put ' . $name . $i . ' in queue');
            };
        }
    }
}
