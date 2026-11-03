@extends('layouts.app')
@section('content')
    <h2>Create Task</h2>
    <p>This is create task page</p>
    <form action="/tasks" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}">
            @error('title')
                <p>{{ $message }}</p>
            @enderror
            
        </div>
        <div>
            <label for="attachment">Attachment</label>
            <input type="file" name="attachment" id="attachment" accept=".pdf, .jpg, .jpeg, .png, .doc, .docx" >
            @error('attachment')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <x-button>Create Task</x-button>
    </form>
@endsection
