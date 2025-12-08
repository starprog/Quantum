<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Activity Library') }}
            </h2>
            <a href="{{ route('children.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Back to Children
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Age Filter Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Filter by Age</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    <a href="{{ route('activities.by-age', ['age' => 3]) }}" class="text-center bg-blue-100 hover:bg-blue-200 py-3 px-4 rounded-lg transition">
                        0-3 months
                    </a>
                    <a href="{{ route('activities.by-age', ['age' => 6]) }}" class="text-center bg-blue-100 hover:bg-blue-200 py-3 px-4 rounded-lg transition">
                        3-6 months
                    </a>
                    <a href="{{ route('activities.by-age', ['age' => 9]) }}" class="text-center bg-blue-100 hover:bg-blue-200 py-3 px-4 rounded-lg transition">
                        6-9 months
                    </a>
                    <a href="{{ route('activities.by-age', ['age' => 12]) }}" class="text-center bg-blue-100 hover:bg-blue-200 py-3 px-4 rounded-lg transition">
                        9-12 months
                    </a>
                    <a href="{{ route('activities.by-age', ['age' => 18]) }}" class="text-center bg-blue-100 hover:bg-blue-200 py-3 px-4 rounded-lg transition">
                        12-18 months
                    </a>
                    <a href="{{ route('activities.by-age', ['age' => 24]) }}" class="text-center bg-blue-100 hover:bg-blue-200 py-3 px-4 rounded-lg transition">
                        18-24 months
                    </a>
                    <a href="{{ route('activities.by-age', ['age' => 30]) }}" class="text-center bg-blue-100 hover:bg-blue-200 py-3 px-4 rounded-lg transition">
                        24-30 months
                    </a>
                    <a href="{{ route('activities.by-age', ['age' => 36]) }}" class="text-center bg-blue-100 hover:bg-blue-200 py-3 px-4 rounded-lg transition">
                        30-36 months
                    </a>
                    <a href="{{ route('activities.by-age', ['age' => 42]) }}" class="text-center bg-blue-100 hover:bg-blue-200 py-3 px-4 rounded-lg transition">
                        36-42 months
                    </a>
                    <a href="{{ route('activities.by-age', ['age' => 48]) }}" class="text-center bg-blue-100 hover:bg-blue-200 py-3 px-4 rounded-lg transition">
                        42-48 months
                    </a>
                </div>
            </div>

            <!-- Activities by Category -->
            @foreach($activities as $category => $categoryActivities)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-4 capitalize border-b pb-2">
                            {{ str_replace('_', ' ', $category) }}
                            <span class="text-sm text-gray-600 font-normal">({{ $categoryActivities->count() }} activities)</span>
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($categoryActivities as $activity)
                                <div class="border rounded-lg p-4 hover:shadow-lg transition">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-semibold text-lg">{{ $activity->title }}</h4>
                                        <span class="text-xs bg-gray-200 px-2 py-1 rounded">
                                            {{ $activity->age_range }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($activity->description, 100) }}</p>
                                    
                                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                                        <span class="flex items-center">
                                            ⏱️ {{ $activity->duration }}
                                        </span>
                                        <span class="capitalize px-2 py-1 rounded 
                                            {{ $activity->difficulty === 'easy' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $activity->difficulty === 'moderate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $activity->difficulty === 'challenging' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ $activity->difficulty }}
                                        </span>
                                    </div>
                                    
                                    <a href="{{ route('activities.show', $activity) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                        View Details
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            @if($activities->isEmpty())
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center">
                    <p class="text-gray-600">No activities found. Please add some activities to get started!</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>