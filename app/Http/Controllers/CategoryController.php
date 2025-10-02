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
     * Ensures the category belongs to the user before deleting.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        // Check if the category belongs to the authenticated user
        if ($category->user_id !== auth()->id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }
        // Delete the category
        $category->delete();
        // Respond with success
        return response()->json(['status' => 'success']);
    }
}
