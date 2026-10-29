<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = $request->user()
            ->tasks()
            ->latest()
            ->paginate(10);
        return TaskResource::collection($tasks);
    }
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $validatedRequest = $request->validated();
        $task = $request->user()
            ->tasks()
            ->create($validatedRequest);
        return (new TaskResource($task))
            ->response()
            ->setStatusCode(201);
    }
}
