<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
}
