@extends('layouts.app')
@section('content')
    <h2>Edit Task</h2>
    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{ $task->title }}">
        @error('title')
            <p>{{ $message }}</p>
        @enderror
        <button type="submit">Update</button>
    </form>
@endsection
