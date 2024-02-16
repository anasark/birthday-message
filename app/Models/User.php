<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Igaster\LaravelCities\Geo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'city',
        'country',
        'timezone',
        'birth_date',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'birth_date'        => 'date',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($user) {
            (new self)->setTimezone($user);
        });

        static::updated(function ($user) {
            (new self)->setTimezone($user);
        });
    }

    /**
     * @param  User $user
     * 
     * @return void
     */
    private function setTimezone(User $user): void
    {
        $list = Geo::searchNames($user->city);
        $user->timezone = $list->first()?->timezone;
        $user->saveQuietly();
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
       return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * @return string
     */
    public function getNineClockAttribute(): string
    {
        $birthDate = $this->birth_date->hour(9);

        if (config('app.timezone') === $this->timezone) {
            return $birthDate->toTimeString();
        }

        if (empty($this->timezone)) {
            return null;
        }

        $date = Carbon::createFromFormat('Y-m-d H:i:s', $birthDate->toDateTimeString(), $this->timezone);
        $date->setTimezone(config('app.timezone'));

        return $date->toTimeString();
    }

    /**
     * @param  string $timezone
     * 
     * @return Collection
     */
    public static function getBirthday(string $timezone): Collection
    {
        $success = ReminderHistory::getUserIds();

        return self::query()
            ->where('timezone', $timezone)
            ->whereNotIn('id', $success)
            ->get()
            ->filter(function(User $user) {
                $birthDate = $user->birth_date;
                $birthDate->setTimezone($user->timezone);
                return $birthDate->isBirthday();
            });
    }

    /**
     * @return array
     */
    public static function getTimezone(): array
    {
        return self::query()
            ->distinct()
            ->pluck('timezone')
            ->toArray();
    }
}
