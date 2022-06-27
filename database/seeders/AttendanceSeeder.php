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
                // 月・火・木・金は全日出勤
                $status = in_array($day->dayOfWeek, [1, 2, 4, 5]) ? 'full' : null;
                // 月は2週に一度欠勤
                if ($day->dayOfWeek === 1 && $day->weekOfMonth % 2 === 0) {
                    $status = 'off';
                    $comment = '休暇';
                }
                // 土は2週に一度半日出勤
                if ($day->dayOfWeek === 6 && $day->weekOfMonth % 2 === 1) {
                    $status = 'half';
                    $comment = '休日出勤';
                }
                // 開始時刻と終了時刻
                if ($status === 'full') {
                    $start_time = Carbon::parse('13:00');
                    $end_time = Carbon::parse('18:00');
                } elseif ($status === 'half') {
                    $start_time = Carbon::parse('13:00');
                    $end_time = Carbon::parse('16:00');
                } elseif ($status === 'off') {
                    $start_time = null;
                    $end_time = null;
                }
                // 登録
                if (!is_null($status)) {
                    Attendance::factory()
                        ->for($user)
                        ->create([
                            'date' => $day,
                            'status' => $status,
                            'start_time' => $start_time,
                            'end_time' => $end_time,
                            'comment' => $comment,
                        ]);
                }
            });
    }
}
