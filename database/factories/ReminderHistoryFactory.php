<?php

namespace Database\Factories;

use App\Models\ReminderHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReminderHistory>
 */
class ReminderHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'user_id' => $user->id,
            'message' => fake()->text(),
            'year'    => date('y'),
            'status'  => ReminderHistory::STATUS_FAILED
        ];
    }
}
