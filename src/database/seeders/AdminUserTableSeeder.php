<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::factory()->count(2)->create();

        Admin::create([
            'name' => 'Admin Name',
            'email' => 'admin@example.com',
            'password' => Hash::make('teestojkovic7195'),
        ]);
    }
}
