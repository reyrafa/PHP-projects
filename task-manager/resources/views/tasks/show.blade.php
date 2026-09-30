@extends('layouts.app')
@section('content')
    <h2>{{ $task->title }}</h2>
    @if ($task->completed)
        <p>Status: Completed</p>
    @else
        <p>Status: Pending</p>
    @endif
    <a href="{{ route('tasks.edit', $task) }}">Edit Task</a>
    <form action="{{ route('tasks.delete', $task) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete Task</button>
    </form>
    <a href="{{ route('tasks.index') }}">Back to tasks</a>
@endsection
