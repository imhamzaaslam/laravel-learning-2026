<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'Marc',
            'email' => 'marc@example.com',
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'Eric',
            'email' => 'eric@example.com',
            'password' => bcrypt('password')
        ]);
    }
}
