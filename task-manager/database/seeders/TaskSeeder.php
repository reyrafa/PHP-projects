<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory()->count(10)->create();
        foreach ($users as $user) {
            Task::factory()->count(10)->create([
                'user_id' => $user->id
            ]);
        }
    }
}
