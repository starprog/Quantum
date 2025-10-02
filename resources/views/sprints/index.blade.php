@extends('layouts.app')

@section('content')
<div class="flex justify-center pt-12">
    <div class="w-full max-w-6xl bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-8 text-center">Project Sprint Manager</h1>
        {{-- Horizontal scrollable board for categories --}}
        <div class="flex gap-6 overflow-x-auto">
            @foreach($categories as $category)
                <div class="flex flex-col bg-gray-50 rounded-lg shadow min-w-[300px] max-w-xs p-4">
                    <h2 class="text-lg font-bold mb-4 text-center">{{ $category->name }}</h2>
                    <div class="flex-1 flex flex-col gap-4 task-dropzone" data-category="{{ $category->id }}">
                        @if($category->name === 'To Do')
                            @php
                                $todoTasks = auth()->user()->tasks()
                                    ->where('completed', false)
                                    ->where(function($q) use ($category) {
                                        $q->whereNull('category_id')
                                          ->orWhere('category_id', $category->id);
                                    })->get();
                            @endphp
                            @forelse($todoTasks as $task)
                                <div class="bg-blue-100 border border-blue-300 rounded p-3 shadow draggable-task" data-id="{{ $task->id }}">
                                    <div class="font-semibold">{{ $task->name }}</div>
                                </div>
                            @empty
                                <div class="text-gray-400 text-center">No tasks to do.</div>
                            @endforelse
                        @else
                            @forelse($category->tasks as $task)
                                <div class="bg-blue-100 border border-blue-300 rounded p-3 shadow draggable-task" data-id="{{ $task->id }}">
                                    <div class="font-semibold">{{ $task->name }}</div>
                                </div>
                            @empty
                                <div class="text-gray-400 text-center">No tasks in this category.</div>
                            @endforelse
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.querySelectorAll('.task-dropzone').forEach(function(dropzone) {
        Sortable.create(dropzone, {
            group: 'tasks',
            animation: 150,
            onAdd: function (evt) {
                let taskId = evt.item.getAttribute('data-id');
                let newCategoryId = evt.to.getAttribute('data-category');
                fetch("{{ route('tasks.move') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ task_id: taskId, category_id: newCategoryId })
                });

                // Hide the "No tasks in this category" watermark if present
                let watermark = evt.to.querySelector('.text-gray-400.text-center');
                if (watermark && evt.to.children.length > 1) {
                    watermark.style.display = 'none';
                }
            },
            onRemove: function (evt) {
                // Show the watermark if the category is now empty
                if (evt.from.children.length === 1) { // Only watermark remains
                    let watermark = evt.from.querySelector('.text-gray-400.text-center');
                    if (watermark) {
                        watermark.style.display = '';
                    }
                }
            }
        });
    });
</script>
@endsection