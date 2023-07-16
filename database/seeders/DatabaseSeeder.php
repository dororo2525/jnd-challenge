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
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::create([
            'name' => 'Nuttapong Binkudsun',
            'email' => 'dororo1995@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
            'remember_token' => Str::random(10),
        ]);
    }
}
