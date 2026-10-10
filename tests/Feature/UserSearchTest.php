<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserSearchTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable();
        });
    }

    public function test_user_search_matches_name_or_email(): void
    {
        $nameMatch = User::factory()->create([
            'name' => 'Taylor Searchable',
            'email' => 'taylor@example.com',
        ]);
        $emailMatch = User::factory()->create([
            'name' => 'Morgan',
            'email' => 'searchable@example.com',
        ]);
        User::factory()->create([
            'name' => 'Jordan',
            'email' => 'jordan@example.com',
        ]);

        $this->getJson('/api/users?search=searchable')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment(['id' => $nameMatch->id])
            ->assertJsonFragment(['id' => $emailMatch->id]);
    }
}
