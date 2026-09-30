<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('tasks.index', [
            'tasks' => $tasks,
            'totalTasks' => $tasks->count()
        ]);
    }
    public function create()
    {
        return view('tasks.create');
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        Task::create($validated);
        return redirect('/tasks');
    }
    public function show(Task $task)
    {
        return view('tasks.show', [
            'task' => $task
        ]);
    }
    public function edit(Task $task)
    {
        return view('tasks.edit', [
            'task' => $task
        ]);
    }
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();
        $task->update($validated);
        return redirect()->route('tasks.show', $task);
    }
    public function delete(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
