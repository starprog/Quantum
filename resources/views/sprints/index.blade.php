@extends('layouts.app')

@section('content')
<div class="flex justify-center pt-12">
    <div class="w-full max-w-6xl bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-8 text-center">Project Sprint Manager</h1>
        {{-- Horizontal scrollable board for categories --}}
        <div class="flex gap-6 overflow-x-auto">
            @foreach($categories as $category)
                <div class="flex flex-col bg-gray-50 rounded-lg shadow min-w-[300px] max-w-xs p-4">
                    <h2 class="text-lg font-bold mb-4 text-center">{{ $category->name }}</h2>
                    <div class="flex-1 flex flex-col gap-4">
                        {{-- Only "To Do" column gets tasks for now --}}
                        @if($category->name === 'To Do')
                            @forelse($todoTasks as $task)
                                <div class="bg-blue-100 border border-blue-300 rounded p-3 shadow">
                                    <div class="font-semibold">{{ $task->name }}</div>
                                </div>
                            @empty
                                <div class="text-gray-400 text-center">No tasks to do.</div>
                            @endforelse
                        @else
                            <div class="text-gray-400 text-center">No tasks yet.</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection