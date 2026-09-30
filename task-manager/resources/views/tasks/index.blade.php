@extends('layouts.app')
@section('content')
    <h1>Task Manager</h1>

    <ul>
        @foreach ($tasks as $task)
            <li>
                <a href="{{ route('tasks.show', $task) }}">
                    {{ $task->title }} - {{ $task->user?->name }}
                </a>


                @if ($task->completed)
                    - Completed
                @else
                    - Pending
                @endif
            </li>
        @endforeach
        {{ $tasks->links() }}
        <p>Total Tasks: {{ $totalTasks }}</p>
    </ul>
@endsection
