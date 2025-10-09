@extends('layouts.app')

@section('content')
<div class="flex justify-center pt-12">
    <div class="w-full max-w-7xl bg-white p-6 rounded shadow">
        <div class="flex items-center justify-between mb-8 relative">
            <h1 class="text-2xl font-bold text-center flex-1">Project Sprint Manager</h1>
            <div class="relative">
                <button id="add-menu-btn" class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full w-10 h-10 flex items-center justify-center text-2xl font-bold" title="Add">+</button>
                <div id="add-menu-dropdown" class="absolute right-0 mt-2 bg-white border rounded shadow flex-nowrap flex z-10" style="white-space: nowrap; display: none;">
                    <button id="add-category-btn" class="block text-left px-4 py-2 hover:bg-gray-100">Add Category</button>
                    <button id="add-task-btn" class="block text-left px-4 py-2 hover:bg-gray-100">Add Task</button>
                </div>
            </div>
        </div>
        <div class="flex items-center">
            <!-- Left Arrow Button -->
            <button id="scroll-left" class="mx-2 bg-gray-200 hover:bg-gray-300 rounded-full w-10 h-10 flex items-center justify-center text-2xl font-bold" title="Scroll left">
                &#8592;
            </button>
            <!-- Category List -->
            <div id="category-list" class="flex gap-6 overflow-x-auto items-start w-full">
                @foreach($categories as $category)
                    <div class="flex flex-col bg-gray-50 rounded-lg shadow min-w-[300px] max-w-xs p-4 relative group" data-id="{{ $category->id }}">
                        <h2 class="category-header text-lg font-bold mb-4 text-center cursor-move">
                            {{ $category->name }}
                        </h2>
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
                                    $todoCategory = auth()->user()->categories()->where('name', 'To Do')->first();

                                    $todoTasks = auth()->user()->tasks()
                                        ->where('completed', false)
                                        ->where(function($q) use ($todoCategory) {
                                            $q->whereNull('category_id');
                                            if ($todoCategory) {
                                                $q->orWhere('category_id', $todoCategory->id);
                                            }
                                        })
                                        ->orderBy('order', 'asc')
                                        ->get();
                                @endphp
                                @forelse($todoTasks as $task)
                                    <div class="bg-blue-100 border border-blue-300 rounded p-3 shadow draggable-task group relative" data-id="{{ $task->id }}" draggable="true">
                                        <div class="font-semibold">{{ $task->name }}</div>
                                        <!-- More actions button, only visible on hover -->
                                        <button
                                            class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity bg-gray-200 hover:bg-gray-300 rounded-full w-8 h-8 flex items-center justify-center"
                                            title="More actions"
                                            onclick="showTaskActions({{ $task->id }})"
                                            type="button"
                                        >&#x2026;</button>
                                        <!-- Actions dropdown menu, hidden by default -->
                                        <div id="task-actions-{{ $task->id }}" class="absolute top-10 right-2 bg-white border rounded shadow p-2 hidden z-10">
                                            <button
                                                class="text-red-600 hover:underline"
                                                onclick="deleteTask({{ $task->id }})"
                                                type="button"
                                            >Delete Task</button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-gray-400 text-center">No tasks to do.</div>
                                @endforelse
                            @else
                                @forelse($category->tasks as $task)
                                    <div class="bg-blue-100 border border-blue-300 rounded p-3 shadow draggable-task group relative" data-id="{{ $task->id }}" draggable="true">
                                        <div class="font-semibold">{{ $task->name }}</div>
                                        <!-- More actions button, only visible on hover -->
                                        <button
                                            class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity bg-gray-200 hover:bg-gray-300 rounded-full w-8 h-8 flex items-center justify-center"
                                            title="More actions"
                                            onclick="showTaskActions({{ $task->id }})"
                                            type="button"
                                        >&#x2026;</button>
                                        <!-- Actions dropdown menu, hidden by default -->
                                        <div id="task-actions-{{ $task->id }}" class="absolute top-10 right-2 bg-white border rounded shadow p-2 hidden z-10">
                                            <button
                                                class="text-red-600 hover:underline"
                                                onclick="deleteTask({{ $task->id }})"
                                                type="button"
                                            >Delete Task</button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-gray-400 text-center">No tasks in this category.</div>
                                @endforelse
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Right Arrow Button -->
            <button id="scroll-right" class="mx-2 bg-gray-200 hover:bg-gray-300 rounded-full w-10 h-10 flex items-center justify-center text-2xl font-bold" title="Scroll right">
                &#8594;
            </button>
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
        <!-- Modal for creating a new task -->
        <div id="add-task-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded shadow w-80">
                <h2 class="text-lg font-bold mb-4">Create New Task</h2>
                <input type="text" id="new-task-name" class="w-full border rounded px-3 py-2 mb-4" placeholder="Task name">
                <div class="flex justify-end gap-2">
                    <button id="cancel-task-btn" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button id="confirm-task-btn" class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Scroll left when left arrow is clicked
    document.getElementById('scroll-left').onclick = function() {
        document.getElementById('category-list').scrollBy({ left: -300, behavior: 'smooth' });
    };
    // Scroll right when right arrow is clicked
    document.getElementById('scroll-right').onclick = function() {
        document.getElementById('category-list').scrollBy({ left: 300, behavior: 'smooth' });
    };

    document.querySelectorAll('.task-dropzone').forEach(function(dropzone) {
        Sortable.create(dropzone, {
            group: 'tasks',
            animation: 150,
            scroll: true, // Enable auto-scroll
            scrollSensitivity: 200, // Wider margin for autoscroll activation
            scrollSpeed: 20,
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
            onEnd: function (evt) {
            // Only update order if this is the To Do category
            if (dropzone.getAttribute('data-category') == '{{ $todoCategory->id ?? "" }}') {
                let order = [];
                dropzone.querySelectorAll('.draggable-task').forEach((el) => {
                    order.push(el.getAttribute('data-id'));
                });

                fetch("{{ route('tasks.reorder') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({ order: order })
                });
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

    // Enable drag-and-drop for categories
    Sortable.create(document.getElementById('category-list'), {
        animation: 150,
        handle: '.category-header',
        scroll: true, // Enable auto-scroll
        scrollSensitivity: 200, // Wider margin for autoscroll activation
        scrollSpeed: 20, // px per frame
        onEnd: function (evt) {
            let order = [];
            document.querySelectorAll('#category-list > [data-id]').forEach((el) => {
                order.push(el.getAttribute('data-id'));
            });

            // Send new order to backend
            fetch("{{ route('categories.reorder') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ order: order })
            }).then(response => response.json())
              .then(data => {
                  if (data.status !== 'success') {
                      alert(data.message);
                      location.reload();
                  }
              });
        }
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

    // Show modal when "Add Task" is clicked
    document.getElementById('add-task-btn').onclick = function() {
        document.getElementById('add-task-modal').style.display = 'flex';
        document.getElementById('add-menu-dropdown').style.display = 'none';
    };
    // Hide modal when cancel is clicked
    document.getElementById('cancel-task-btn').onclick = function() {
        document.getElementById('add-task-modal').style.display = 'none';
        document.getElementById('new-task-name').value = '';
    };

    // Handle task creation
    document.getElementById('confirm-task-btn').onclick = function() {
        let name = document.getElementById('new-task-name').value.trim();
        if (name.length === 0) return;

        fetch("{{ route('tasks.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({ name: name })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Close the modal and clear the input
                document.getElementById('add-task-modal').style.display = 'none';
                document.getElementById('new-task-name').value = '';
                // Reload the page to show the new task
                location.reload();
            } else {
                alert('Failed to create task.');
            }
        })
        .catch(() => {
            alert('There was an error creating the task.');
        });
    };

    // Show/hide the add menu dropdown
    document.getElementById('add-menu-btn').onclick = function() {
        const dropdown = document.getElementById('add-menu-dropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    };
    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#add-menu-btn') && !e.target.closest('#add-menu-dropdown')) {
            document.getElementById('add-menu-dropdown').style.display = 'none';
        }
    });

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

    function showTaskActions(taskId) {
        // Hide all other task action menus
        document.querySelectorAll('[id^="task-actions-"]').forEach(el => el.style.display = 'none');
        // Show the selected task's actions menu
        document.getElementById('task-actions-' + taskId).style.display = 'block';
    }

    // Hide all task actions menus when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.draggable-task') && !e.target.closest('[id^="task-actions-"]')) {
            document.querySelectorAll('[id^="task-actions-"]').forEach(el => el.style.display = 'none');
        }
    });

    function deleteTask(taskId) {
        if (!confirm('Are you sure you want to delete this task?')) return;
        fetch("{{ url('/tasks') }}/" + taskId, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(response => response.json())
          .then(data => {
              if (data.status === 'success') {
                  // Remove the task card from the DOM
                  const taskCard = document.querySelector('.draggable-task[data-id="' + taskId + '"]');
                  if (taskCard) taskCard.remove();
              }
          });
    }

    // Autoscroll when dragging over left/right arrow panes
    let scrollInterval = null;

    // Left pane autoscroll
    document.getElementById('scroll-left-pane').addEventListener('dragenter', function() {
        clearInterval(scrollInterval);
        scrollInterval = setInterval(function() {
            document.getElementById('category-list').scrollBy({ left: -30, behavior: 'auto' });
        }, 50);
    });
    document.getElementById('scroll-left-pane').addEventListener('dragleave', function() {
        clearInterval(scrollInterval);
    });
    document.getElementById('scroll-left-pane').addEventListener('drop', function() {
        clearInterval(scrollInterval);
    });

    // Right pane autoscroll
    document.getElementById('scroll-right-pane').addEventListener('dragenter', function() {
        clearInterval(scrollInterval);
        scrollInterval = setInterval(function() {
            document.getElementById('category-list').scrollBy({ left: 30, behavior: 'auto' });
        }, 50);
    });
    document.getElementById('scroll-right-pane').addEventListener('dragleave', function() {
        clearInterval(scrollInterval);
    });
    document.getElementById('scroll-right-pane').addEventListener('drop', function() {
        clearInterval(scrollInterval);
    });
</script>
@endsection