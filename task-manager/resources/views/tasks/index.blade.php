@extends('layouts.app')
@section('content')
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
    <h1>Task Manager</h1>

    <ul>
        @foreach ($tasks as $task)
            <li>
                <a href="{{ route('tasks.show', $task) }}">
                    {{ $task->title }} - {{ auth()->user()->name }}
                </a>


                @if ($task->completed)
                    - Completed
                @else
                    - Pending
                @endif
            </li>
        @endforeach


        <p>Total Tasks: {{ $summary['total'] }}</p>
        <p>Total Pending Tasks: {{ $summary['pending'] }}</p>
        <p>Total Completed Tasks: {{ $summary['completed'] }}</p>
    </ul>
@endsection
