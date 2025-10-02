@extends('layouts.app')

@section('content')
<div class="flex justify-center pt-12">
    <div class="w-full max-w-6xl bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-8 text-center">Project Sprint Manager</h1>
        {{-- Horizontal scrollable board for categories --}}
        <div class="flex gap-6 overflow-x-auto items-start">
            @foreach($categories as $category)
                <div class="flex flex-col bg-gray-50 rounded-lg shadow min-w-[300px] max-w-xs p-4 relative group">
                    <h2 class="text-lg font-bold mb-4 text-center">{{ $category->name }}</h2>
                    {{-- More actions button, only visible when hovering over the category pane --}}
                    <button
                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity bg-gray-200 hover:bg-gray-300 rounded-full w-8 h-8 flex items-center justify-center"
                        title="More actions"
                        onclick="showCategoryActions({{ $category->id }})"
                    >&#x2026;</button>
                    {{-- Actions dropdown menu, hidden by default --}}
                    <div id="category-actions-{{ $category->id }}" class="absolute top-10 right-2 bg-white border rounded shadow p-2 hidden z-10">
                        <button
                            class="text-red-600 hover:underline"
                            onclick="deleteCategory({{ $category->id }})"
                        >Delete Category</button>
                    </div>
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

            <!-- Add Category Button -->
            <div class="flex flex-col justify-center items-center min-w-[100px]">
                <button
                    id="add-category-btn"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full w-10 h-10 flex items-center justify-center text-2xl font-bold"
                    title="Add Category"
                >+</button>
            </div>
        </div>
        <!-- Modal for creating a new category -->
        <div id="add-category-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded shadow w-80">
                <h2 class="text-lg font-bold mb-4">Create New Category</h2>
                <input type="text" id="new-category-name" class="w-full border rounded px-3 py-2 mb-4" placeholder="Category name">
                <div class="flex justify-end gap-2">
                    <button id="cancel-category-btn" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button id="confirm-category-btn" class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
                </div>
            </div>
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

    // Show modal when "+" button is clicked
    document.getElementById('add-category-btn').onclick = function() {
        document.getElementById('add-category-modal').style.display = 'flex';
    };

    // Hide modal when cancel is clicked
    document.getElementById('cancel-category-btn').onclick = function() {
        document.getElementById('add-category-modal').style.display = 'none';
        document.getElementById('new-category-name').value = '';
    };

    // Handle category creation
    document.getElementById('confirm-category-btn').onclick = function() {
        let name = document.getElementById('new-category-name').value.trim();
        if (name.length === 0) return;

        fetch("{{ route('categories.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ name: name })
        }).then(response => response.json())
          .then(data => {
              if (data.status === 'success') {
                  location.reload();
              }
          });
    };

    /**
     * Show the actions dropdown for the selected category.
     * Hides all other action menus before showing the selected one.
     *
     * @param {number} categoryId - The ID of the category to show actions for.
     */
    function showCategoryActions(categoryId) {
        // Hide all other action menus
        document.querySelectorAll('[id^="category-actions-"]').forEach(el => el.style.display = 'none');
        // Show the selected category's actions menu
        document.getElementById('category-actions-' + categoryId).style.display = 'block';
    }

    /**
     * Hide all actions menus when clicking outside of any category pane or actions menu.
     */
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.group') && !e.target.closest('[id^="category-actions-"]')) {
            document.querySelectorAll('[id^="category-actions-"]').forEach(el => el.style.display = 'none');
        }
    });

    /**
     * Delete a category via AJAX.
     * Prompts for confirmation before sending the delete request.
     *
     * @param {number} categoryId - The ID of the category to delete.
     */
    function deleteCategory(categoryId) {
        if (!confirm('Are you sure you want to delete this category?')) return;
        fetch("{{ url('/categories') }}/" + categoryId, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        }).then(response => response.json())
          .then(data => {
              if (data.status === 'success') {
                  location.reload();
              }
          });
    }
</script>
@endsection