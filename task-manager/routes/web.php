<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])
    ->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');

    Route::post('/tasks', [TaskController::class, 'store'])
    ->name('tasks.store');

    Route::get('/tasks/{task}', [TaskController::class, 'show'])
    ->can('view', 'task')
    ->name('tasks.show');

    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])
    ->name('tasks.edit');

    Route::put('/tasks/{task}', [TaskController::class, 'update'])
    ->name('tasks.update');

    Route::delete('/tasks/{task}', [TaskController::class, 'delete'])
    ->can('delete', 'task')
    ->name('tasks.delete');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');