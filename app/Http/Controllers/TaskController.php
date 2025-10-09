<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the authenticated user's tasks,
     * ordered with incomplete tasks first and completed tasks last.
     * Also calculates metrics for total, completed, and incomplete tasks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get tasks ordered by completion status and custom order
        $tasks = auth()->user()->tasks()
            ->orderBy('completed') // incomplete first, completed last
            ->orderBy('order')     // then by drag-and-drop order
            ->get();

        // Calculate metrics for display
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('completed', true)->count();
        $incompleteTasks = $tasks->where('completed', false)->count();

        // Calculate percentage completed
        $percentComplete = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // Pass tasks and metrics to the view
        return view('tasks.index', compact('tasks', 'totalTasks', 'completedTasks', 'incompleteTasks', 'percentComplete'));
    }

    /**
     * Store a newly created task for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {
                $request->validate(['name' => 'required|string|max:255']);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['status' => 'error', 'errors' => $e->errors()], 422);
            }
        } else {
            $request->validate(['name' => 'required|string|max:255']);
        }

        $user = auth()->user();

        $todoCategory = $user->categories()->where('name', 'To Do')->first();
        $maxOrder = $user->tasks()
            ->where('category_id', $todoCategory ? $todoCategory->id : null)
            ->max('order');

        $task = $user->tasks()->create([
            'name' => $request->name,
            'completed' => false,
            'category_id' => $todoCategory ? $todoCategory->id : null,
            'order' => $maxOrder !== null ? $maxOrder + 1 : 1,
        ]);

        // If AJAX, return JSON. Otherwise, redirect back to the ToDo list page.
        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'task' => $task]);
        } else {
            return redirect()->route('tasks.index'); // or your ToDo list route
        }
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task)
    {
        //$this->authorize('delete', $task);
        $task->delete();
        if (request()->ajax()) {
            return response()->json(['status' => 'success']);
        }
        return redirect()->back()->with('status', 'Task deleted!');
    }

    /**
     * Toggle the completion status of the specified task.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Task $task)
    {
        $task->completed = !$task->completed;
        $task->save();

        return redirect()->route('tasks.index');
    }

    /**
     * Update the order of tasks based on drag-and-drop sorting.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reorder(Request $request)
    {
        $order = $request->order; // array of task IDs in new order
        foreach ($order as $index => $taskId) {
            Task::where('id', $taskId)->update(['order' => $index + 1]);
        }
        return response()->json(['status' => 'success']);
    }

    /**
     * Move a task to a new category after drag-and-drop.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function move(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        $categoryId = $request->category_id;

        // Find the "Done" category for this user
        $doneCategory = $task->user->categories()->where('name', 'Done')->first();

        // Mark as complete if moved to Done, incomplete otherwise
        if ($doneCategory && $categoryId == $doneCategory->id) {
            $task->completed = true;
        } else {
            $task->completed = false;
        }

        $task->category_id = $categoryId;
        $task->save();

        return response()->json(['status' => 'success']);
    }
}
