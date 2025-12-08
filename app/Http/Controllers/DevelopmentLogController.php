<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\DevelopmentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevelopmentLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display development logs for a child.
     */
    public function index(Child $child)
    {
        $this->authorize('view', $child);

        $logs = $child->developmentLogs()->with('loggedBy')->paginate(20);

        return view('logs.index', compact('child', 'logs'));
    }

    /**
     * Show the form for creating a new development log.
     */
    public function create(Child $child)
    {
        $this->authorize('update', $child);

        return view('logs.create', compact('child'));
    }

    /**
     * Store a newly created development log.
     */
    public function store(Request $request, Child $child)
    {
        $this->authorize('update', $child);

        $validated = $request->validate([
            'log_date' => 'required|date|before_or_equal:today',
            'category' => 'required|in:motor_skills,language,social_skills,cognitive,general',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media' => 'nullable|array',
        ]);

        $validated['child_id'] = $child->id;
        $validated['logged_by'] = Auth::id();

        DevelopmentLog::create($validated);

        return redirect()->route('logs.index', $child)
            ->with('success', 'Development log added successfully!');
    }

    /**
     * Display the specified development log.
     */
    public function show(Child $child, DevelopmentLog $log)
    {
        $this->authorize('view', $child);

        return view('logs.show', compact('child', 'log'));
    }

    /**
     * Show the form for editing the specified development log.
     */
    public function edit(Child $child, DevelopmentLog $log)
    {
        $this->authorize('update', $child);

        return view('logs.edit', compact('child', 'log'));
    }

    /**
     * Update the specified development log.
     */
    public function update(Request $request, Child $child, DevelopmentLog $log)
    {
        $this->authorize('update', $child);

        $validated = $request->validate([
            'log_date' => 'required|date|before_or_equal:today',
            'category' => 'required|in:motor_skills,language,social_skills,cognitive,general',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media' => 'nullable|array',
        ]);

        $log->update($validated);

        return redirect()->route('logs.index', $child)
            ->with('success', 'Development log updated successfully!');
    }

    /**
     * Remove the specified development log.
     */
    public function destroy(Child $child, DevelopmentLog $log)
    {
        $this->authorize('update', $child);

        $log->delete();

        return redirect()->route('logs.index', $child)
            ->with('success', 'Development log deleted.');
    }

    /**
     * Filter logs by category.
     */
    public function filterByCategory(Child $child, $category)
    {
        $this->authorize('view', $child);

        $logs = $child->developmentLogs()
            ->where('category', $category)
            ->with('loggedBy')
            ->paginate(20);

        return view('logs.index', compact('child', 'logs', 'category'));
    }
}