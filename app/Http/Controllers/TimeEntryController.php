<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeEntry;

class TimeEntryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $entries = $user->timeEntries()->orderBy('clock_in', 'desc')->get();
        $activeEntry = $user->timeEntries()->whereNull('clock_out')->latest()->first();

        return view('time-tracker.index', compact('entries', 'activeEntry'));
    }

    public function clockIn(Request $request)
    {
        $user = auth()->user();

        // Prevent multiple active sessions
        if ($user->timeEntries()->whereNull('clock_out')->exists()) {
            return redirect()->route('time-tracker.index')->with('error', 'Already clocked in!');
        }

        $user->timeEntries()->create([
            'clock_in' => now(),
        ]);

        return redirect()->route('time-tracker.index');
    }

    public function clockOut(Request $request)
    {
        $user = auth()->user();
        $entry = $user->timeEntries()->whereNull('clock_out')->latest()->first();

        if ($entry) {
            $entry->clock_out = now();
            $entry->save();
        }

        return redirect()->route('time-tracker.index');
    }
}
