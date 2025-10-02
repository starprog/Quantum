<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Store a new category for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $user = auth()->user();
        $order = $user->categories()->max('order') + 1;

        $category = $user->categories()->create([
            'name' => $request->name,
            'order' => $order,
        ]);

        return response()->json(['status' => 'success', 'category' => $category]);
    }

    /**
     * Delete a category for the authenticated user.
     * Prevents deletion of default categories.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        // Prevent deletion of default categories
        $defaultNames = ['To Do', 'In Progress', 'Done'];
        if (in_array($category->name, $defaultNames)) {
            return response()->json(['status' => 'error', 'message' => 'Cannot delete default category.'], 403);
        }

        // Check if the category belongs to the authenticated user
        if ($category->user_id !== auth()->id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }
        // Delete the category
        $category->delete();
        // Respond with success
        return response()->json(['status' => 'success']);
    }

    /**
     * Reorder categories based on drag-and-drop.
     * Enforces that "To Do" is first, "In Progress" is after "To Do", and "Done" is after "In Progress".
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reorder(Request $request)
    {
        $user = auth()->user();
        $order = $request->order; // Array of category IDs in new order

        // Fetch categories by IDs in the new order
        $categories = Category::whereIn('id', $order)->get()->keyBy('id');

        // Build array of category names in new order
        $names = [];
        foreach ($order as $id) {
            $names[] = $categories[$id]->name;
        }

        // Safety check: "To Do" must be first
        if ($names[0] !== 'To Do') {
            return response()->json(['status' => 'error', 'message' => '"To Do" must be the first category.']);
        }

        // Safety check: "In Progress" must be after "To Do"
        $inProgressIndex = array_search('In Progress', $names);
        if ($inProgressIndex === false || $inProgressIndex < 1) {
            return response()->json(['status' => 'error', 'message' => '"In Progress" must be after \"To Do\".']);
        }

        // Safety check: "Done" must be after "In Progress"
        $doneIndex = array_search('Done', $names);
        if ($doneIndex === false || $doneIndex <= $inProgressIndex) {
            return response()->json(['status' => 'error', 'message' => '"Done" must be after \"In Progress\".']);
        }

        // Update order in DB
        foreach ($order as $i => $id) {
            $categories[$id]->order = $i;
            $categories[$id]->save();
        }

        return response()->json(['status' => 'success']);
    }
}
