<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_status_is_saved_and_returned_by_the_api(): void
    {
        $this->postJson('/api/tasks', [
            'title' => 'Prepare report',
            'status' => 'in_progress',
        ])->assertOk();

        $this->assertDatabaseHas('tasks', [
            'title' => 'Prepare report',
            'status' => 'in_progress',
        ]);

        $this->getJson('/api/tasks')
            ->assertOk()
            ->assertJsonPath('data.0.status', 'in_progress');
    }

    public function test_task_api_rejects_unsupported_status_values(): void
    {
        $this->postJson('/api/tasks', [
            'title' => 'Prepare report',
            'status' => 'blocked',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('status');
    }
}
