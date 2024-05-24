<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use phpseclib3\Net\SSH2;
use App\Models\Api\Task;


class Discord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discord:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        exec('cd $HOME/pythontest/ && python3 discord.py');
        $discord = Task::where('name', 'discord:task')->first();
        $discord->time = rand(1,57) . ' ' . rand(20, 21) . ' * * *';
        $discord->save();
    }
}

