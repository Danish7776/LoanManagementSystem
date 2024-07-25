<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'developer',
            'phone' => '1234567890',
            'username' => 'developer',
            'password' => Hash::make('Test@Password123#'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
