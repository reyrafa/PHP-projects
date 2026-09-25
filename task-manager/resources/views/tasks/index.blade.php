@extends('layouts.app')
@section('content')
    <h1>Task Manager</h1>

    <ul>
        @foreach ($tasks as $task)
            <li>
                <a href="{{ route('tasks.show', $task) }}">
                    {{ $task->title }}
                </a>


                @if ($task->completed)
                    - Completed
                @else
                    - Pending
                @endif
            </li>
        @endforeach
        <p>Total Tasks: {{ $totalTasks }}</p>
    </ul>
@endsection
