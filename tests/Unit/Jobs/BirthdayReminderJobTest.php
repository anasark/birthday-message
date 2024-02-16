<?php

namespace Tests\Unit\Jobs;

use App\Jobs\BirthdayReminderJob;
use App\Models\ReminderHistory;
use App\Models\User;
use App\Services\SendBirthdayReminder;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class BirthdayReminderJobTest extends TestCase
{
    /** @test */
    public function birthdayReminderJobSuccess()
    {
        Queue::fake();

        $user    = User::find(1);
        $history = ReminderHistory::factory()->create([
            'user_id' => $user->id,
            'status'  => ReminderHistory::STATUS_SUCCESS,
        ]);

        $mockService = $this->mock(SendBirthdayReminder::class);
        $mockService->shouldReceive('sendNow')->andReturn($history);

        BirthdayReminderJob::dispatch($user);

        $this->assertDatabaseHas('reminder_histories', [
            'id'     => $history->id,
            'status' => ReminderHistory::STATUS_SUCCESS,
        ]);
    }

    /** @test */
    public function birthdayReminderJobFailedAndRetry()
    {
        Queue::fake();

        $user = User::find(1);
        $history = ReminderHistory::factory()->create([
            'user_id' => $user->id,
            'status'  => ReminderHistory::STATUS_FAILED,
            'retries' => 2,
        ]);

        $mockService = $this->mock(SendBirthdayReminder::class);
        $mockService->shouldReceive('sendNow')->andReturn($history);

        BirthdayReminderJob::dispatch($user, $history->id);

        Queue::assertPushed(BirthdayReminderJob::class);
    }

    /** @test */
    public function birthdayReminderJobFailedAndNotRetry()
    {
        Queue::fake();

        $user = User::find(1);
        $history = ReminderHistory::factory()->create([
            'user_id' => $user->id,
            'status'  => ReminderHistory::STATUS_FAILED,
            'retries' => 3,
        ]);

        $mockService = $this->mock(SendBirthdayReminder::class);
        $mockService->shouldReceive('sendNow')->andReturn($history);

        $job = new BirthdayReminderJob($user, $history->id);
        $job->handle();

        Queue::assertNotPushed(BirthdayReminderJob::class);
    }
}
