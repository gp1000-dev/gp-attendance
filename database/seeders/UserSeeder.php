<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'クリエイター1',
            'last_name' => '久里',
            'first_name' => '英太',
            'last_kana_name' => 'クリ',
            'first_kana_name' => 'エイタ',
            'email' => 'creator1@example.com',
            'password' => Hash::make('P@ssw0rd'),
            'gender' => 'male',
            'birthdate' => \Carbon\Carbon::parse('2001-05-01'),
        ]);
    }
}
