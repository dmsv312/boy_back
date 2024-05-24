<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use phpseclib3\Net\SSH2;
use App\Models\Api\Task;

class SquidAxlUsdc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'squid:axlusdc';

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
        exec('cd $HOME/pythontest/ && python3 open_firefox_keplr.py');
        exec('cd $HOME/pythontest/ && python3 squid_axl_usdc.py');
        $squidAxlUsdc = Task::where('name', 'squid:axlusdc')->first();
        $squidAxlUsdc->delete();
    }
}

