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

    public function test_user_can_login(): void
    {
        $user = User::factory()->create();
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ])->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]);
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_sees_only_thier_own_tasks(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user1->tasks()->create([
            'title' => 'Learn PHP Testing',
            'completed' => false
        ]);
        $user2->tasks()->create([
            'title' => 'Learn Pest',
            'completed' => false
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
                'title' => 'Learn something new'
            ])
            ->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'title' => 'Learn something new'
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

    public function test_user_cannot_view_another_users_task(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $userATask = $userA->tasks()->create([
            'title' => 'UserA Task',
            'completed' => false
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
                'completed' => false
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
            'completed' => false
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
