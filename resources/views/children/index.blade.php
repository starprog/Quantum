<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Children') }}
            </h2>
            <a href="{{ route('children.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Child
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($children->isEmpty())
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center">
                    <p class="text-gray-600 mb-4">You haven't added any children yet.</p>
                    <a href="{{ route('children.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Your First Child
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($children as $child)
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    @if($child->profile_photo)
                                        <img src="{{ asset('storage/' . $child->profile_photo) }}" alt="{{ $child->full_name }}" class="w-16 h-16 rounded-full object-cover mr-4">
                                    @else
                                        <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl font-bold mr-4">
                                            {{ substr($child->first_name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $child->full_name }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $child->age_display }}</p>
                                    </div>
                                </div>

                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Milestones:</span>
                                        <span class="font-semibold">{{ $child->achievedMilestones->count() }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Growth Records:</span>
                                        <span class="font-semibold">{{ $child->growthRecords->count() }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('children.show', $child) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    View Profile
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>