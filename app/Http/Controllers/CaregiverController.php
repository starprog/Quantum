<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Caregiver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaregiverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display caregivers for a child.
     */
    public function index(Child $child)
    {
        $this->authorize('view', $child);

        $caregivers = $child->caregivers()->with('user')->orderBy('is_primary', 'desc')->get();

        return view('caregivers.index', compact('child', 'caregivers'));
    }

    /**
     * Show the form for adding a caregiver.
     */
    public function create(Child $child)
    {
        $this->authorize('update', $child);

        $relationships = [
            'parent' => 'Parent',
            'grandparent' => 'Grandparent',
            'guardian' => 'Guardian',
            'daycare' => 'Daycare Provider',
            'pediatrician' => 'Pediatrician',
            'other' => 'Other'
        ];

        $accessLevels = [
            'full' => 'Full Access',
            'view_only' => 'View Only',
            'collaborative' => 'Collaborative'
        ];

        return view('caregivers.create', compact('child', 'relationships', 'accessLevels'));
    }

    /**
     * Store a newly added caregiver.
     */
    public function store(Request $request, Child $child)
    {
        $this->authorize('update', $child);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'relationship' => 'required|in:parent,grandparent,guardian,daycare,pediatrician,other',
            'access_level' => 'required|in:full,view_only,collaborative',
            'can_edit' => 'boolean',
            'is_primary' => 'boolean',
        ]);

        // Check if caregiver already exists
        $existing = Caregiver::where('child_id', $child->id)
            ->where('user_id', $validated['user_id'])
            ->first();

        if ($existing) {
            return back()->withErrors(['user_id' => 'This user is already a caregiver for this child.']);
        }

        $validated['child_id'] = $child->id;
        $validated['can_edit'] = $request->has('can_edit');
        $validated['is_primary'] = $request->has('is_primary');

        Caregiver::create($validated);

        return redirect()->route('caregivers.index', $child)
            ->with('success', 'Caregiver added successfully!');
    }

    /**
     * Display the specified caregiver.
     */
    public function show(Child $child, Caregiver $caregiver)
    {
        $this->authorize('view', $child);

        $caregiver->load('user');

        return view('caregivers.show', compact('child', 'caregiver'));
    }

    /**
     * Show the form for editing caregiver permissions.
     */
    public function edit(Child $child, Caregiver $caregiver)
    {
        $this->authorize('update', $child);

        $relationships = [
            'parent' => 'Parent',
            'grandparent' => 'Grandparent',
            'guardian' => 'Guardian',
            'daycare' => 'Daycare Provider',
            'pediatrician' => 'Pediatrician',
            'other' => 'Other'
        ];

        $accessLevels = [
            'full' => 'Full Access',
            'view_only' => 'View Only',
            'collaborative' => 'Collaborative'
        ];

        return view('caregivers.edit', compact('child', 'caregiver', 'relationships', 'accessLevels'));
    }

    /**
     * Update caregiver permissions.
     */
    public function update(Request $request, Child $child, Caregiver $caregiver)
    {
        $this->authorize('update', $child);

        $validated = $request->validate([
            'relationship' => 'required|in:parent,grandparent,guardian,daycare,pediatrician,other',
            'access_level' => 'required|in:full,view_only,collaborative',
            'can_edit' => 'boolean',
            'is_primary' => 'boolean',
        ]);

        $validated['can_edit'] = $request->has('can_edit');
        $validated['is_primary'] = $request->has('is_primary');

        $caregiver->update($validated);

        return redirect()->route('caregivers.index', $child)
            ->with('success', 'Caregiver permissions updated successfully!');
    }

    /**
     * Remove caregiver access.
     */
    public function destroy(Child $child, Caregiver $caregiver)
    {
        $this->authorize('update', $child);

        // Prevent removing the child's primary parent
        if ($caregiver->user_id === $child->user_id) {
            return back()->withErrors(['error' => 'Cannot remove the primary parent.']);
        }

        $caregiver->delete();

        return redirect()->route('caregivers.index', $child)
            ->with('success', 'Caregiver access removed.');
    }

    /**
     * Search for users to add as caregivers.
     */
    public function search(Request $request, Child $child)
    {
        $this->authorize('update', $child);

        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email address.']);
        }

        // Check if already a caregiver
        $existing = Caregiver::where('child_id', $child->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return back()->withErrors(['email' => 'This user is already a caregiver for this child.']);
        }

        return redirect()->route('caregivers.create', $child)
            ->with('found_user', $user);
    }
}