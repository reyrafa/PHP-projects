<?php

namespace App\Http\Controllers;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = [
            [
                'title' => 'Learn PHP',
                'completed' => true,
            ],
            [
                'title' => 'Learn Laravel',
                'completed' => true,
            ],
            [
                'title' => 'Build API',
                'completed' => false,
            ],
            [
                'title' => 'Learn Docker',
                'completed' => false,
            ],
        ];
        return view('tasks.index', [
            'tasks' => $tasks,
            'totalTasks' => count($tasks)
        ]);
    }
    public function create()
    {
        return view('tasks.create');
    }

    public function store(){
        dd(request()->all());
    }
}
