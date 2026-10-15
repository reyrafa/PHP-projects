<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;




class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $tasks = $request->user()
            ->tasks()
            ->with('user')
            ->where('completed', false)
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

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $request->user()
            ->tasks()
            ->create($validated);
        return redirect('/tasks')->with('status', 'Task created successfully.');
    }
    public function show(Task $task): View
    {
        return view('tasks.show', [
            'task' => $task
        ]);
    }
    public function edit(Task $task): View
    {
        return view('tasks.edit', [
            'task' => $task
        ]);
    }
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $validated = $request->validated();
        $task->update($validated);
        return redirect()->route('tasks.show', $task)->with('status', 'Task updated successfully.');
    }
    public function delete(Task $task): RedirectResponse
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('status', 'Task deleted successfully.');
    }
}
