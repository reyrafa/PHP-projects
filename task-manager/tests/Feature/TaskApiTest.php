<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_only_retrieve_thier_own_tasks(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user1->tasks()->create([
            'title' => 'Learn Programming'
        ]);
        $user2->tasks()->create([
            'title' => 'Learn Python'
        ]);
        Sanctum::actingAs($user1);
        $this->getJson('/api/tasks')->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'title' => 'Learn Programming'
            ])
            ->assertJsonMissing([
                'title' => 'Learn Python'
            ]);
    }

    public function test_guest_cannot_access_tasks(): void
    {
        $this->getJson('/api/tasks')->assertUnauthorized();
    }

    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $this->postJson('/api/tasks', [
            'title' => 'Learn Java'
        ])->assertCreated()->assertJsonPath('data.title', 'Learn Java');
        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'title' => 'Learn Java'
        ]);
    }

    public function test_task_creation_requires_title(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $this->postJson('/api/tasks', [
            'title' => ''
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('title');

        $this->assertDatabaseCount('tasks', 0);
    }
}
