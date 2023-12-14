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
        /** @var Transaction $transaction */
        $transaction = Transaction::orderBy('id')->where('is_complete', 0)->first();
        /** @var Task $swapTask */
        $swapTask = Task::orderBy('id')->where('transaction_id', $transaction->id)->first();
        $schedule->command('swap:cron')->cron($swapTask->time);
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
