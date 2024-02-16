<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $this->scheduleBirthday($schedule);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * @param  Schedule $schedule
     * 
     * @return void
     */
    private function scheduleBirthday(Schedule $schedule): void
    {
        foreach (User::getTimezone() as $timezone) {
            $schedule->command('birthday-reminder:send ' . $timezone)
                ->timezone($timezone)
                ->at('9:00');
        }
    }
}
