<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        $thisMonth = Carbon::today()->startOfMonth();

        // 3ヶ月前〜1日前 の勤怠データ作成
        collect(CarbonPeriod::create($thisMonth->clone()->addMonth(-3), Carbon::today()->addDay(-1))->toArray())
            ->map(function ($day) use ($user) {
                $isWorkDay = !in_array($day->dayOfWeek, [0, 3, 6]);
                $attended = $isWorkDay && (rand(0, 4) < 4) || !$isWorkDay && (rand(0, 4) === 0);
                Attendance::factory()
                    ->for($user)
                    ->create([
                        'date' => $day,
                        'attended' => $attended,
                        'start_time' => $attended ? Carbon::parse('13:00') : null,
                        'end_time' => $attended ? Carbon::parse('18:00') : null,
                        'comment' => $isWorkDay && !$attended ? '休暇' : (!$isWorkDay && $attended ? '休日出勤' : null),
                    ]);
            });
    }
}
