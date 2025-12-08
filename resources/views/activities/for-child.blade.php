<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Activities for {{ $child->full_name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('activities.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    All Activities
                </a>
                <a href="{{ route('children.show', $child) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Back to Profile
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Child Info Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <div class="flex items-center">
                    @if($child->profile_photo)
                        <img src="{{ asset('storage/' . $child->profile_photo) }}" alt="{{ $child->full_name }}" class="w-16 h-16 rounded-full object-cover mr-4">
                    @else
                        <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl font-bold mr-4">
                            {{ substr($child->first_name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="text-xl font-bold">{{ $child->full_name }}</h3>
                        <p class="text-gray-600">{{ $child->age_display }} ({{ $ageInMonths }} months)</p>
                        <p class="text-sm text-gray-500">{{ $groupedActivities->sum(fn($activities) => $activities->count()) }} age-appropriate activities</p>
                    </div>
                </div>
            </div>

            @if($groupedActivities->isEmpty())
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center">
                    <p class="text-gray-600 mb-4">No activities found for this age range.</p>
                    <a href="{{ route('activities.index') }}" class="text-blue-500 hover:text-blue-700">
                        Browse all activities →
                    </a>
                </div>
            @else
                <!-- Activities by Category -->
                @foreach($groupedActivities as $category => $activities)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-4 capitalize border-b pb-2 flex items-center">
                                @if($category === 'sensory')
                                    <span class="mr-2">👋</span>
                                @elseif($category === 'motor_skills')
                                    <span class="mr-2">🤸</span>
                                @elseif($category === 'cognitive')
                                    <span class="mr-2">🧠</span>
                                @elseif($category === 'language')
                                    <span class="mr-2">💬</span>
                                @elseif($category === 'social')
                                    <span class="mr-2">👥</span>
                                @elseif($category === 'creative')
                                    <span class="mr-2">🎨</span>
                                @elseif($category === 'outdoor')
                                    <span class="mr-2">🌳</span>
                                @elseif($category === 'music')
                                    <span class="mr-2">🎵</span>
                                @endif
                                {{ str_replace('_', ' ', $category) }}
                                <span class="text-sm text-gray-600 font-normal ml-2">({{ $activities->count() }} activities)</span>
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($activities as $activity)
                                    <div class="border rounded-lg p-5 hover:shadow-lg transition">
                                        <div class="flex justify-between items-start mb-3">
                                            <h4 class="font-semibold text-lg">{{ $activity->title }}</h4>
                                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                                {{ $activity->age_range }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-gray-600 text-sm mb-4">{{ $activity->description }}</p>
                                        
                                        <div class="grid grid-cols-2 gap-2 text-xs mb-4">
                                            <div class="flex items-center text-gray-600">
                                                <span class="mr-1">⏱️</span>
                                                <span>{{ $activity->duration }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="capitalize px-2 py-1 rounded 
                                                    {{ $activity->difficulty === 'easy' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $activity->difficulty === 'moderate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $activity->difficulty === 'challenging' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ $activity->difficulty }}
                                                </span>
                                            </div>
                                        </div>

                                        @if($activity->developmental_benefits)
                                            <div class="mb-4 p-3 bg-purple-50 rounded">
                                                <p class="text-xs font-semibold text-purple-900 mb-1">Benefits:</p>
                                                <p class="text-xs text-purple-800">{{ Str::limit($activity->developmental_benefits, 100) }}</p>
                                            </div>
                                        @endif
                                        
                                        <a href="{{ route('activities.show', $activity) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                            View Full Details
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>