<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Nuttapong Binkudsun',
            'email' => 'nuttapong@nuttapong.com',
            'password' => Hash::make('123456'),
            'role' => 'user',
            'remember_token' => Str::random(10),
        ]);
    }
}
