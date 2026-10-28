<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TaskAttachmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task_without_attachment(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'learn something'
        ]);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'learn something',
            'user_id' => $user->id,
            'attachment_path' => null
        ]);
    }

    public function test_user_cannot_create_task_without_title(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('tasks.store'), [
            'title' => ''
        ])->assertSessionHasErrors('title');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_user_can_create_task_with_attachment(): void
    {
        Storage::fake('local');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create(
            'notes.pdf',
            100,
            'application/pdf'
        );
        $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'Learn Something',
            'attachment' => $file
        ])->assertSessionHasNoErrors()->assertRedirect(route('tasks.index'));
        $task = Task::where('title', 'Learn Something')
            ->firstOrFail();
        $this->assertNotNull($task->attachment_path);
        Storage::disk('local')->assertExists($task->attachment_path);
    }

    public function test_user_cannot_download_another_user_attachment(): void
    {
        Storage::fake('local');
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $path = 'task-attachments/private.pdf';
        Storage::disk('local')->put($path, 'example private file');
        $task = $user1->tasks()->create([
            'title' => 'Example',
            'attachment_path' => $path
        ]);
        $this->actingAs($user2)->get(route('tasks.attachment.download', $task))
            ->assertForbidden();
    }
}
