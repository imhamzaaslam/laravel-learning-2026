<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::truncate();

        Task::create([
            'uuid' => uuid_create(), // Generate a unique UUID for the task
            'title' => 'Fix bug in UI dashboard page',
            'description' => 'Description for Task 1',
            'due_date' => '2026-09-17',
            'estimated_time' => '2 hours',
        ]);

        Task::create([
            'uuid' => uuid_create(), // Generate a unique UUID for the task
            'title' => 'Implement export functionality',
            'description' => 'Description for Task 2',
            'due_date' => '2026-09-15',
            'estimated_time' => '2 hours',
        ]);


        Task::create([
            'uuid' => uuid_create(), // Generate a unique UUID for the task
            'title' => 'Add sales report',
            'description' => '',
            'due_date' => '2026-09-22',
            'estimated_time' => '3.5 hours',
        ]);
    }
}
