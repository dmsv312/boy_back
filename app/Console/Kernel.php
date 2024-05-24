<?php

namespace App\Console;

use App\Models\Api\Task;
use App\Models\Api\Transaction;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Раз в день удалить старые задачи и запланировать новые
        // $schedule->command('plan:schedule')->dailyAt('22:00');

        // $dayOfWeek = getdate()['wday'];
        // $schedule->command('plan:schedule')->cron('1 22 * * ' . $dayOfWeek);

        // $forgeEvmosUsdc = Task::where('name', 'forge:evmosusdc')->first();
        // $forgeUsdcEvmos = Task::where('name', 'forge:usdcevmos')->first();
        // $ibcEvmosAxl = Task::where('name', 'ibc:evmosaxl')->first();
        // $ibcAxlEvmos = Task::where('name', 'ibc:axlevmos')->first();

        // $schedule->command($forgeEvmosUsdc->name)->cron($forgeEvmosUsdc->time);
        // $schedule->command($forgeUsdcEvmos->name)->cron($forgeUsdcEvmos->time);
        // $schedule->command($ibcEvmosAxl->name)->cron($ibcEvmosAxl->time);
        // $schedule->command($ibcAxlEvmos->name)->cron($ibcAxlEvmos->time);

        // /** @var Transaction $transaction */
        // $transaction = Transaction::orderBy('id')->where('is_complete', 0)->first();
        // /** @var Task $swapTask */
        // $swapTask = Task::orderBy('id')->where('transaction_id', $transaction->id)->first();
        // $schedule->command('swap:cron')->cron($swapTask->time);

        $schedule->command('plan:schedule')->dailyAt('00:01');
        $squidAxlUsdc = Task::where('name', 'squid:axlusdc')->first();
        $squidUsdcAxl = Task::where('name', 'squid:usdcaxl')->first();
        $discord = Task::where('name', 'discord:task')->first();
        if ($squidAxlUsdc->is_active) {
            $schedule->command($squidAxlUsdc->name)->cron($squidAxlUsdc->time);
        }
        if ($squidUsdcAxl->is_active) {
            $schedule->command($squidUsdcAxl->name)->cron($squidUsdcAxl->time);
        }
        if ($discord && $discord->is_active) {
            $schedule->command($discord->name)->cron($discord->time);
        }
        

//        $swapTask = Task::orderBy('id', 'DESC')->where('name', 'swap:cron')->first();
//        $day = $swapTask->getWeekDay();
//
//        while ($day <= 6) {
//            /** @var Task $swapTask */
//            $swapTask = Task::orderBy('id', 'DESC')->where('name', 'swap:cron')->first();
//            $newTask = $swapTask->calculateAndSaveNextSwapTime();
//            $day = $newTask->getWeekDay();
//            if ($day == 7) {
//                break;
//            }
//        }
//        /** @var Task $swapTask */
//        $swapTask = Task::orderBy('id', 'DESC')->where('name', 'swap:cron')->first();
//        $schedule->command('swap:cron')->cron($swapTask->time);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
