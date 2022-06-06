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
                $comment = null;
                // 月・火・木・金は出勤
                $status = in_array($day->dayOfWeek, [1, 2, 4, 5]) ? 'ON' : null;
                // 月は2週に一度欠勤
                if ($day->dayOfWeek === 1 && $day->weekOfMonth % 2 === 0) {
                    $status = 'OFF';
                    $comment = '休暇';
                }
                // 土は2週に一度出勤
                if ($day->dayOfWeek === 6 && $day->weekOfMonth % 2 === 1) {
                    $status = 'ON';
                    $comment = '休日出勤';
                }
                if (!is_null($status)) {
                    Attendance::factory()
                        ->for($user)
                        ->create([
                            'date' => $day,
                            'attended' => $status === 'ON' ? true : false,
                            'start_time' => $status === 'ON' ? Carbon::parse('13:00') : null,
                            'end_time' => $status === 'ON' ? Carbon::parse('18:00') : null,
                            'comment' => $comment,
                        ]);
                }
            });
    }
}
