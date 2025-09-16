@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Task List</h1>
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <input type="text" name="name" placeholder="New Task" required>
        <button type="submit">Add Task</button>
    </form>
    <ul>
        @foreach ($tasks as $task)
            <li>
                {{ $task->name }}
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection