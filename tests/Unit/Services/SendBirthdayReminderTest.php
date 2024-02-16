<?php

namespace Tests\Unit\Services;

use App\Models\ReminderHistory;
use App\Models\User;
use App\Services\SendBirthdayReminder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SendBirthdayReminderTest extends TestCase
{
    /** @test */
    public function sendReminderSuccessfully()
    {
        Http::fake([
            'https://email-service.digitalenvision.com.au/send-email' => Http::response([], 200),
        ]);

        $user            = User::find(1);
        $reminderService = new SendBirthdayReminder($user);
        $history         = $reminderService->sendNow();

        $this->assertInstanceOf(ReminderHistory::class, $history);
        $this->assertEquals(ReminderHistory::STATUS_SUCCESS, $history->status);
    }

    /** @test */
    public function sendReminderFailed()
    {
        Http::fake([
            'https://email-service.digitalenvision.com.au/send-email' => Http::response([], 500),
        ]);

        $user            = User::find(1);
        $reminderService = new SendBirthdayReminder($user);
        $history         = $reminderService->sendNow();

        $this->assertInstanceOf(ReminderHistory::class, $history);
        $this->assertEquals(ReminderHistory::STATUS_FAILED, $history->status);
    }

    /** @test */
    public function updateExistingHistory()
    {
        Http::fake([
            'https://email-service.digitalenvision.com.au/send-email' => Http::response([], 500),
        ]);

        $user    = User::find(1);
        $history = ReminderHistory::factory()->create(['user_id' => $user->id]);

        $reminderService = new SendBirthdayReminder($user, 'Custom message', $history->id);
        $newHistory      = $reminderService->sendNow();

        $this->assertEquals($history->id, $newHistory->id);
        $this->assertEquals(ReminderHistory::STATUS_FAILED, $newHistory->status);
    }
}
