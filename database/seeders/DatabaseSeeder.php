<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'admin_id' => 'dalafarm',
            'password' => bcrypt('dalafarm'),
            'department_name' => '',
            'job_title' => '',
            'name' => 'Dalafarm',
            'furi_name' => 'Dalafarm',
            'email' => 'user9876123james@gmail.com',
            'phone' => '0000000000',
            'break' => 1,
            'pwd_store' => 'dalafarm'
        ]);
    }
}
