<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $child->full_name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('activities.for-child', $child) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    View Activities
                </a>
                <a href="{{ route('children.edit', $child) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit Profile
                </a>
                <a href="{{ route('children.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Child Info Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-start">
                        @if($child->profile_photo)
                            <img src="{{ asset('storage/' . $child->profile_photo) }}" alt="{{ $child->full_name }}" class="w-24 h-24 rounded-full object-cover mr-6">
                        @else
                            <div class="w-24 h-24 rounded-full bg-blue-500 flex items-center justify-center text-white text-4xl font-bold mr-6">
                                {{ substr($child->first_name, 0, 1) }}
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold mb-2">{{ $child->full_name }}</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-600">Age: <span class="font-semibold">{{ $child->age_display }}</span></p>
                                    <p class="text-gray-600">Date of Birth: <span class="font-semibold">{{ $child->date_of_birth->format('M d, Y') }}</span></p>
                                    <p class="text-gray-600">Gender: <span class="font-semibold">{{ ucfirst($child->gender) }}</span></p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Age Range: <span class="font-semibold">{{ $child->getAgeRangeCategory() }} months</span></p>
                                    @if($latestGrowth)
                                        <p class="text-gray-600">Latest Weight: <span class="font-semibold">{{ $latestGrowth->weight_kg }} kg</span></p>
                                        <p class="text-gray-600">Latest Height: <span class="font-semibold">{{ $latestGrowth->height_cm }} cm</span></p>
                                    @endif
                                </div>
                            </div>
                            @if($child->notes)
                                <p class="text-gray-600 mt-4">{{ $child->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <a href="{{ route('milestones.index', $child) }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-4 px-6 rounded text-center">
                    <div class="text-3xl mb-2">🎯</div>
                    <div>Milestones</div>
                    <div class="text-sm mt-1">{{ $child->achievedMilestones->count() }} achieved</div>
                </a>
                <a href="{{ route('growth.index', $child) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-4 px-6 rounded text-center">
                    <div class="text-3xl mb-2">📊</div>
                    <div>Growth</div>
                    <div class="text-sm mt-1">{{ $child->growthRecords->count() }} records</div>
                </a>
                <a href="{{ route('logs.index', $child) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded text-center">
                    <div class="text-3xl mb-2">📝</div>
                    <div>Development Logs</div>
                    <div class="text-sm mt-1">{{ $child->developmentLogs->count() }} entries</div>
                </a>
                <a href="{{ route('caregivers.index', $child) }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-4 px-6 rounded text-center">
                    <div class="text-3xl mb-2">👥</div>
                    <div>Caregivers</div>
                    <div class="text-sm mt-1">Manage access</div>
                </a>
            </div>

            <!-- Recommended Milestones -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-4">Recommended Milestones for Age</h3>
                    @if($recommendedMilestones->isEmpty())
                        <p class="text-gray-600">No milestones available for this age range.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($recommendedMilestones->take(6) as $milestone)
                                @if($milestone)
                                <div class="border rounded p-3">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="font-semibold">{{ $milestone->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $milestone->description }}</p>
                                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 mt-2">
                                                {{ ucfirst(str_replace('_', ' ', $milestone->category)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <a href="{{ route('milestones.index', $child) }}" class="inline-block mt-4 text-blue-500 hover:text-blue-700">
                        View all milestones →
                    </a>
                </div>
            </div>

            <!-- Recent Development Logs -->
            @if($child->developmentLogs->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-4">Recent Development Logs</h3>
                        <div class="space-y-4">
                            @foreach($child->developmentLogs->take(5) as $log)
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <p class="font-semibold">{{ $log->title }}</p>
                                    <p class="text-sm text-gray-600">{{ Str::limit($log->description, 100) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $log->log_date->format('M d, Y') }} • {{ ucfirst(str_replace('_', ' ', $log->category)) }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('logs.index', $child) }}" class="inline-block mt-4 text-blue-500 hover:text-blue-700">
                            View all logs →
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>