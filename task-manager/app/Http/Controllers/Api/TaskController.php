<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tasks = $request->user()
            ->tasks()
            ->latest()
            ->get(['id', 'title', 'completed']);
        return response()->json([
            'data' => $tasks
        ]);
    }
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $validatedRequest = $request->validated();
        $task = $request->user()
            ->tasks()
            ->create($validatedRequest);
        return response()->json([
            'data' => $task
        ], 201);
    }
}
