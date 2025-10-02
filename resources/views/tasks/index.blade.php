@extends('layouts.app')

@section('content')
<div class="flex justify-center pt-12">
    <div class="w-full max-w-md bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4 text-center">Task List</h1>

        {{-- Display metrics for total, completed, and incomplete tasks --}}
        <div class="mb-4 text-center">
            <span class="font-bold">Total Tasks:</span> {{ $totalTasks }}
            <span class="mx-2">|</span>
            <span class="text-green-600 font-bold">Completed:</span> {{ $completedTasks }}
            <span class="mx-2">|</span>
            <span class="text-blue-600 font-bold">To Do:</span> {{ $incompleteTasks }}
        </div>

        {{-- Percentage completed progress bar --}}
        {{-- Green for completed portion, red for incomplete portion --}}
        <div class="mb-4">
            <div class="w-full bg-red-200 rounded-full h-6 flex overflow-hidden">
                <div
                    class="h-6 bg-green-500 flex items-center justify-center"
                    style="width: {{ $percentComplete }}%;">
                    @if($percentComplete > 10)
                        <span class="text-white font-bold px-2">{{ $percentComplete }}%</span>
                    @endif
                </div>
                <div
                    class="h-6 bg-red-500 flex items-center justify-center"
                    style="width: {{ 100 - $percentComplete }}%;">
                    @if($percentComplete <= 90)
                        <span class="text-white font-bold px-2">{{ 100 - $percentComplete }}% left</span>
                    @endif
                </div>
            </div>
        </div>

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

        {{-- Drag-and-drop enabled task list with numbered items --}}
        <ul id="task-list">
            @foreach ($tasks as $task)
                <li data-id="{{ $task->id }}" class="flex justify-between items-center mb-2 border-b pb-2">
                    <div class="flex items-center gap-2">
                        {{-- Display the task's position in the list --}}
                        <span class="font-bold text-gray-500">{{ $loop->iteration }}.</span>
                        {{-- Checkbox to toggle completion --}}
                        <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                            @csrf
                            <input type="checkbox" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                        </form>
                        {{-- Task name, styled if completed --}}
                        <span class="{{ $task->completed ? 'line-through text-gray-400' : '' }}">
                            {{ $task->name }}
                        </span>
                    </div>
                    {{-- Delete button for the task --}}
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

{{-- JavaScript to handle drag-and-drop reordering and send new order to backend --}}
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

                // Send new order to backend via AJAX
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