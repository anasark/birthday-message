<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderHistory extends Model
{
    use HasFactory;

    protected $guarded = [];

    /** @var integer */
    public const STATUS_SUCCESS = 1;

    /** @var integer */
    public const STATUS_FAILED = 0;

    /** @var integer[] */
    public const STATUS = [
        self::STATUS_SUCCESS,
        self::STATUS_FAILED,
    ];

    /**
     * @param  integer|boolean $status
     * 
     * @return array
     */
    public static function getUserIds($status = self::STATUS_SUCCESS): array
    {
        $query = self::query()
            ->where('status', $status)
            ->where('year', date('Y'));

        if ($status == self::STATUS_FAILED) {
            $query->where('retries', '<', 3);
        }

        return $query
            ->pluck('user_id')
            ->toArray();
    }
}
