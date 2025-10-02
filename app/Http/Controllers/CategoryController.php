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
}
