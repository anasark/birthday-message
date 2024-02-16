<?php

namespace App\Console\Commands;

use App\Jobs\BirthdayReminderJob;
use App\Models\User;
use Illuminate\Console\Command;

class BirthdayReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday-reminder:send {timezone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder to send birthday messages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::getBirthday($this->argument('timezone'));

        foreach ($users as $user) {
            BirthdayReminderJob::dispatch($user);
        }
    }
}
