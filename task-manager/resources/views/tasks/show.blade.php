@extends('layouts.app')
@section('content')
    <h2>{{ $task->title }}</h2>
    @if ($task->completed)
        <p>Status: Completed</p>
    @else
        <p>Status: Pending</p>
    @endif
    <a href="{{ route('tasks.index') }}">Back to tasks</a>
@endsection
