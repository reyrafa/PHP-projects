<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_tasks(): void
    {
        $this->get(route('tasks.index'))
            ->assertRedirect(route('login'));
    }


    public function test_user_sees_only_thier_own_tasks(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user1->tasks()->create([
            'title' => 'Learn PHP Testing',
            'description' => 'PHP',
            'priority' => 'high',
            'due_date' => now()
        ]);
        $user2->tasks()->create([
            'title' => 'Learn Pest',
            'description' => '',
            'priority' => 'medium',
            'due_date' => now()
        ]);
        $this->actingAs($user1)
            ->get(route('tasks.index'))
            ->assertOk()
            ->assertSee('Learn PHP Testing')
            ->assertDontSee('Learn Pest');
    }

    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->post(route('tasks.store'), [
                'title' => 'Learn something new',
                'description' => '',
                'priority' => 'low',
                'due_date' => ''
            ])
            ->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'description' => null,
            'title' => 'Learn something new',
            'priority' => 'low',
            'due_date' => null
        ]);
    }

    public function test_task_title_is_required(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->post(route('tasks.store'), [
                'title' => ''
            ])
            ->assertSessionHasErrors('title');
        $this->assertDatabaseCount('tasks', 0);
    }
    public function test_task_priority_is_required(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->post(route('tasks.store'), [
                'priority' => ''
            ])->assertSessionHasErrors('priority');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_user_cannot_view_another_users_task(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $userATask = $userA->tasks()->create([
            'title' => 'UserA Task',
            'desciption' => '',
            'priority' => 'medium',
            'due_date' => null,
        ]);
        $this->actingAs($userB)
            ->get(route('tasks.show', $userATask))
            ->assertForbidden();
    }

    public function test_user_cannot_update_another_users_task(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $userATask = $userA->tasks()
            ->create([
                'title' => 'Learn Something new',
                'priority' => 'medium'
            ]);
        $this->actingAs($userB)
            ->put(route('tasks.update', $userATask), [
                'title' => 'This will be my Task'
            ])
            ->assertForbidden();
        $this->assertDatabaseHas('tasks', [
            'id' => $userATask->id,
            'user_id' => $userA->id,
            'title' => 'Learn Something new'
        ]);
    }

    public function test_user_cannot_delete_another_user_tasks(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $userATask = $userA->tasks()->create([
            'title' => 'Task for A',
            'priority' => 'low'
        ]);
        $this->actingAs($userB)
            ->delete(route('tasks.delete', $userATask))
            ->assertForbidden();
        $this->assertDatabaseHas('tasks', [
            'id' => $userATask->id,
            'user_id' => $userA->id,
            'title' => 'Task for A'
        ]);
    }
}
