<?php

namespace Starprog\BibleVerseAdmin\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class VerseCategoryController extends Controller
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = config('bible-verse-admin.models.verse_category');
    }

    /**
     * Display a listing of verse categories
     */
    public function index()
    {
        $perPage = config('bible-verse-admin.pagination.categories', 20);
        $categories = $this->categoryModel::withCount('verses')->orderBy('name')->paginate($perPage);
        return view('bible-verse-admin::categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('bible-verse-admin::categories.create');
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

        $this->categoryModel::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit($id)
    {
        $category = $this->categoryModel::findOrFail($id);
        return view('bible-verse-admin::categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, $id)
    {
        $category = $this->categoryModel::findOrFail($id);
        
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
    public function destroy($id)
    {
        $category = $this->categoryModel::findOrFail($id);
        
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
