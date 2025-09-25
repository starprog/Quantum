@extends('layouts.app')

@section('content')
<div class="flex justify-center pt-12">
    <div class="w-full max-w-xl bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4 text-center">Time Tracker</h1>

        @if(session('error'))
            <div class="mb-4 text-red-600 font-bold text-center">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-6 text-center">
            @if($activeEntry)
                <form method="POST" action="{{ route('time-tracker.clock-out') }}">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 font-bold">
                        Clock Out
                    </button>
                </form>
                <p class="mt-2 text-gray-700">Clocked in at: <strong>{{ $activeEntry->clock_in->format('g:i A, M d Y') }}</strong></p>
            @else
                <form method="POST" action="{{ route('time-tracker.clock-in') }}">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-bold">
                        Clock In
                    </button>
                </form>
            @endif
        </div>

        <h2 class="text-xl font-semibold mb-2 text-center">Recent Sessions</h2>
        <table class="w-full text-left border">
            <thead>
                <tr>
                    <th class="px-2 py-1 border">Date</th>
                    <th class="px-2 py-1 border">Clock In</th>
                    <th class="px-2 py-1 border">Clock Out</th>
                    <th class="px-2 py-1 border">Duration</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entries as $entry)
                    <tr>
                        <td class="px-2 py-1 border">{{ $entry->clock_in->format('M d, Y') }}</td>
                        <td class="px-2 py-1 border">{{ $entry->clock_in->format('g:i A') }}</td>
                        <td class="px-2 py-1 border">
                            {{ $entry->clock_out ? $entry->clock_out->format('g:i A') : '—' }}
                        </td>
                        <td class="px-2 py-1 border">
                            @if($entry->clock_out)
                                {{ $entry->clock_in->diffForHumans($entry->clock_out, true) }}
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection