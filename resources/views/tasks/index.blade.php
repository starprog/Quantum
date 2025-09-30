@extends('layouts.app')

@section('content')
<div class="flex justify-center pt-12">
    <div class="w-full max-w-md bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4 text-center">Task List</h1>
        <form method="POST" action="{{ route('tasks.store') }}" class="mb-4 flex gap-2">
            @csrf
            <input 
                type="text" 
                name="name" 
                placeholder="New Task" 
                required 
                class="px-3 py-2 border rounded w-2/3"
            >
            <button 
                type="submit" 
                class="px-6 py-2 bg-blue-600 text-white rounded font-bold hover:bg-blue-700"
                style="display: inline-block;"
            >
                Add Task
            </button>
        </form>
        {{-- Drag-and-drop enabled task list --}}
        <ul id="task-list">
            @foreach ($tasks as $task)
                <li data-id="{{ $task->id }}" class="flex justify-between items-center mb-2 border-b pb-2">
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                            @csrf
                            <input type="checkbox" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                        </form>
                        <span class="{{ $task->completed ? 'line-through text-gray-400' : '' }}">
                            {{ $task->name }}
                        </span>
                    </div>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

{{-- SortableJS CDN script for drag-and-drop functionality --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var el = document.getElementById('task-list');
        var sortable = Sortable.create(el, {
            animation: 150,
            onEnd: function (evt) {
                let order = [];
                document.querySelectorAll('#task-list li').forEach((li) => {
                    order.push(li.getAttribute('data-id'));
                });

                fetch("{{ route('tasks.reorder') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ order: order })
                });
            }
        });
    });
</script>