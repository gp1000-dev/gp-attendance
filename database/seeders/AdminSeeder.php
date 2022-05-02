<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::factory()->create([
            'name' => '管理者1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('P@ssw0rd'),
        ]);
    }
}
