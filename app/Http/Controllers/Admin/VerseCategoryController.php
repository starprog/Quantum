<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerseCategory;
use Illuminate\Http\Request;

class VerseCategoryController extends Controller
{
    /**
     * Display a listing of verse categories
     */
    public function index()
    {
        $categories = VerseCategory::withCount('verses')->orderBy('name')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:verse_categories,name',
            'slug' => 'required|string|max:100|unique:verse_categories,slug',
            'description' => 'nullable|string',
        ]);

        VerseCategory::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(VerseCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, VerseCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:verse_categories,name,' . $category->id,
            'slug' => 'required|string|max:100|unique:verse_categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category
     */
    public function destroy(VerseCategory $category)
    {
        // Check if category has verses
        if ($category->verses()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with existing verses. Please reassign or delete the verses first.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
