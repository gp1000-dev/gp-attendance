<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'attended',
        'start_time',
        'end_time',
        'comment',
    ];

    /**
     * Datetime accessers.
     *
     * @var array
     */
    protected $dates = [
        'date',
        'start_time',
        'end_time',
    ];

    /**
     * Parent user model
     *
     * @var App\Models\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Caluculate working times
     *
     * @return \Carbon\Carbon
     */
    public function workTime()
    {
        $startTime = new Carbon($this->start_time);
        $endTime = new Carbon($this->end_time);
        $diff = $endTime->diffInMinutes($startTime);

        $workHours = floor($diff / 60);
        $workMinutes = $diff % 60;
        $workTimes = $workHours . ':' . $workMinutes;

        return new Carbon($workTimes);
    }
}
