<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeEntry;

class TimeEntryController extends Controller
{
    /**
     * Display the time tracker page with all time entries and the current active entry.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $entries = $user->timeEntries()->orderBy('clock_in', 'desc')->get();
        $activeEntry = $user->timeEntries()->whereNull('clock_out')->latest()->first();

        // Calculate total minutes for completed sessions
        $totalMinutes = $entries->reduce(function ($carry, $entry) {
            if ($entry->clock_out) {
                return $carry + $entry->clock_in->diffInMinutes($entry->clock_out);
            }
            return $carry;
        }, 0);

        return view('time-tracker.index', compact('entries', 'activeEntry', 'totalMinutes'));
    }

    /**
     * Clock in the authenticated user by creating a new time entry.
     * Prevents multiple active sessions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Clock out the authenticated user by updating the latest active time entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
