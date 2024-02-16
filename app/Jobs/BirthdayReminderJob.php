<?php

namespace App\Jobs;

use App\Models\ReminderHistory;
use App\Models\User;
use App\Services\SendBirthdayReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BirthdayReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var integer $tries
     */
    public $tries = 2;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var integer
     */
    public $backoff = 30;

    /**
     * The number of seconds the job can run before timing out (killed).
     *
     * @var integer
     */
    public $timeout = 30;

    /**
     * @var User $user
     */
    private User $user;

    /**
     * @var integer|null $historyId
     */
    private int|null $historyId;

    /**
     * Create a new job instance.
     *
     * @param  User         $user
     * @param  integer|null $historyId
     */
    public function __construct(User $user, ?int $historyId = null)
    {
        $this->user      = $user;
        $this->historyId = $historyId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $request = new SendBirthdayReminder($this->user, null, $this->historyId);
        $history = $request->sendNow();

        if ($history->status == ReminderHistory::STATUS_FAILED) {
            $this->failedHandler($history);
        }
    }

    /**
     * @param  ReminderHistory $history
     * 
     * @return void
     */
    private function failedHandler(ReminderHistory $history): void
    {
        if ($history->retries > 2) {
            return;
        }

        self::dispatch($this->user, $history->id)->delay(now()->addMinutes(30));

        $history->retries = $history->retries + 1;
        $history->save();
    }
}
