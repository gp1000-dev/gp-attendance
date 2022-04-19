<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Carbon\Carbon;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startTime = $this->faker->datetimeBetween(Carbon::parse('09:00'), Carbon::parse('13:00'));

        return [
            'user_id' => User::factory(),
            'date' => $this->faker->datetimeBetween('-1 year', 'today'),
            'attended' => $this->faker->boolean(80),
            'start_time' => $startTime,
            'end_time' => $this->faker->datetimeBetween($startTime, Carbon::parse('21:00')),
            'comment' => $this->faker->realText(50),
        ];
    }
}
