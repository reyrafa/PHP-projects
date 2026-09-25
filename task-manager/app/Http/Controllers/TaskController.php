<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
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
}
