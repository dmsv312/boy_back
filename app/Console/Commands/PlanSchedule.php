<?php

namespace App\Console\Commands;

use App\Models\Api\ArchiveNode;
use App\Models\Api\Exorde;
use App\Models\Api\Node;
use App\Models\Api\Server;
use App\Models\Api\Task;
use App\Models\Api\Token;
use App\Models\Api\Transaction;
use App\Models\User;
use App\Notifications\TelegramNotification;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use phpseclib3\Net\SSH2;

class PlanSchedule extends Command
{
    public const FORGE_EVMOS_USDC = 'forge:evmosusdc';
    public const FORGE_USDC_EVMOS = 'forge:usdcevmos';
    public const SQUID_AXL_USDC = 'squid:axlusdc';
    public const SQUID_USDC_AXL = 'squid:usdcaxl';
    public const IBC_EVMOS_AXL = 'ibc:evmosaxl';
    public const IBC_AXL_EVMOS = 'ibc:axlevmos';

    public $slots = [
        1 => 6,
        2 => 7,
        3 => 8,
        4 => 9,
        5 => 10,
        6 => 11,
    ];

    public $modules = [
        'forge' => ['forge:evmosusdc', 'forge:usdcevmos'],
        'squid' => ['squid:axlusdc', 'squid:usdcaxl'],
        'ibc' => ['ibc:evmosaxl', 'ibc:axlevmos'],
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:schedule';

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
        $dayOfWeek = getdate()['wday'];

        // clean tasks
        $tasks1 = Task::where('name', 'squid:axlusdc')->get();
        $tasks2 = Task::where('name', 'squid:usdcaxl')->get();

        foreach ($tasks1 as $task) {
            $task->delete();
        }

        foreach ($tasks2 as $task) {
            $task->delete();
        }

        $hour1 = rand(6, 10) - 2;
        $minute1 = rand(1, 50);
        $task1 = new Task();
        $task1->name = 'squid:axlusdc';
        $task1->time = $minute1 . ' ' . $hour1 . ' * * ' . $dayOfWeek;
        $task1->save();   

        $hour2 = $hour1 + rand(1,2);
        $minute2 = rand(1, 50);
        $task2 = new Task();
        $task2->name = 'squid:usdcaxl';
        $task2->time = $minute2 . ' ' . $hour2 . ' * * ' . $dayOfWeek;
        $task2->save();

        $hour3 = rand(13, 15) - 2;
        $minute3 = rand(1, 50);
        $task3 = new Task();
        $task3->name = 'squid:axlusdc';
        $task3->time = $minute3 . ' ' . $hour3 . ' * * ' . $dayOfWeek;
        $task3->save();   

        $hour4 = $hour3 + rand(1,2);
        $minute4 = rand(1, 50);
        $task4 = new Task();
        $task4->name = 'squid:usdcaxl';
        $task4->time = $minute4 . ' ' . $hour4 . ' * * ' . $dayOfWeek;
        $task4->save();

        $hour5 = rand(18, 19) - 2;
        $minute5 = rand(1, 50);
        $task5 = new Task();
        $task5->name = 'squid:axlusdc';
        $task5->time = $minute5 . ' ' . $hour5 . ' * * ' . $dayOfWeek;
        $task5->save();   

        $hour6 = $hour5 + rand(1,2);
        $minute6 = rand(1, 50);
        $task6 = new Task();
        $task6->name = 'squid:usdcaxl';
        $task6->time = $minute6 . ' ' . $hour6 . ' * * ' . $dayOfWeek;
        $task6->save();
        
        $tasks = Task::all();
        $homeUrl = '65.109.31.171/api/v1/save-task';

        foreach($tasks as $task) {
            $responseObject = Http::post(
                $homeUrl, [
                    'device' => env('LOCATION', false),
                    'name' => $task->name,
                    'time' => $task->time,
                    'day' => $task->getWeekDay(),
                ]
            )->object();
        }

        // shuffle($this->modules);

        // $task = Task::firstOrNew(['name' => $this->modules[0][0]]);
        // $task->time = rand(1, 57) . ' ' . $this->slots[1] . ' * * ' . $dayOfWeek;
        // $task->save();

        // $task = Task::firstOrNew(['name' => $this->modules[0][1]]);
        // $task->time = rand(1, 57) . ' ' . $this->slots[2] . ' * * ' . $dayOfWeek;
        // $task->save();

        // $task = Task::firstOrNew(['name' => $this->modules[1][0]]);
        // $task->time = rand(1, 57) . ' ' . $this->slots[3] . ' * * ' . $dayOfWeek;
        // $task->save();

        // $task = Task::firstOrNew(['name' => $this->modules[1][1]]);
        // $task->time = rand(1, 57) . ' ' . $this->slots[4] . ' * * ' . $dayOfWeek;
        // $task->save();

        // $task = Task::firstOrNew(['name' => $this->modules[2][0]]);
        // $task->time = rand(1, 57) . ' ' . $this->slots[5] . ' * * ' . $dayOfWeek;
        // $task->save();

        // $task = Task::firstOrNew(['name' => $this->modules[2][1]]);
        // $task->time = rand(1, 57) . ' ' . $this->slots[6] . ' * * ' . $dayOfWeek;
        // $task->save();
//
//        /** @var Task $swapTask */
//        $swapTask = Task::orderBy('id', 'DESC')->where('name', 'swap:cron')->first();
//        $swapTask->calculateAndSaveNextSwapTime();
    }
}

