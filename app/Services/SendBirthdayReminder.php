<?php

namespace App\Services;

use App\Jobs\BirthdayReminderJob;
use App\Models\ReminderHistory;
use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendBirthdayReminder
{
    /**
     * @var User $user
     */
    private User $user;

    /**
     * @var integer|null $historyId
     */
    private int|null $historyId;

    /**
     * @var bool $isSucess
     */
    private bool $isSucess  = false;

    /**
     * @var string $message
     */
    private string $message = "Hey, %s it's your birthday";

    /**
     * @var string $url
     */
    private string $url = 'https://email-service.digitalenvision.com.au/send-email';

    /**
     * @param User         $user
     * @param string|null  $message
     * @param integer|null $historyId
     */
    public function __construct(User $user, string $message = null, ?int $historyId = null)
    {
        $this->user      = $user;
        $this->historyId = $historyId;
        $this->message   = empty($message)
            ? sprintf($this->message, $this->user->full_name)
            : $message;
    }

    /**
     * @return ReminderHistory
     */
    public function sendNow(): ReminderHistory
    {
        Log::info('Start send reminder', [
            'user_id' => $this->user->id
        ]);

        $response = Http::post($this->url, [
            'email'   => $this->user->email,
            'message' => $this->message,
        ]);

        return $this->parseResponse($response);
    }

    /**
     * @param  Response $response
     * 
     * @return ReminderHistory
     */
    private function parseResponse(Response $response): ReminderHistory
    {
        $this->isSucess = $response->status() == 200;
        $history        = $this->recordHistory();
        $logData        = [
            'user_id'    => $this->user->id,
            'history_id' => $history->id
        ];
        
        if ($this->isSucess) {
            Log::info('Birthday reminder email sent', $logData);
        } else {
            Log::error('Birthday reminder email failed to send', $logData);
        }

        return $history;
    }

    /**
     * @return ReminderHistory
     */
    private function recordHistory(): ReminderHistory
    {
        $status = $this->isSucess
            ? ReminderHistory::STATUS_SUCCESS
            : ReminderHistory::STATUS_FAILED;

        if ($this->historyId) {
            $history         = ReminderHistory::find($this->historyId);
            $history->status = $status;
            $history->save();

            return $history;
        }

        return ReminderHistory::create([
            'user_id' => $this->user->id,
            'message' => $this->message,
            'year'    => date('Y'),
            'status'  => $status,
        ]);
    }
}
