<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

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

        Attendance::factory()
            ->for($user)
            ->create([
                'date' => Carbon::parse('2022-04-01'),
                'attended' => true,
                'start_time' => Carbon::parse('13:00'),
                'end_time' => Carbon::parse('18:00'),
                'comment' => '通常出所',
            ]);
    }
}
