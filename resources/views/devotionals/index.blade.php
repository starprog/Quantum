<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Devotional Plans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Active Devotionals -->
            @if($myProgress->isNotEmpty())
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">📖 My Active Devotionals</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($myProgress as $progress)
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-md p-6 border-2 border-blue-200">
                                <h4 class="text-xl font-semibold text-gray-900 mb-2">
                                    {{ $progress->devotionalPlan->name }}
                                </h4>
                                
                                <p class="text-sm text-gray-700 mb-4">
                                    Day {{ $progress->current_day }} of {{ $progress->devotionalPlan->duration_days }}
                                </p>

                                <div class="mb-4">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Progress</span>
                                        <span>{{ $progress->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-white rounded-full h-3">
                                        <div class="bg-blue-600 h-3 rounded-full transition-all" style="width: {{ $progress->progress_percentage }}%"></div>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('devotionals.daily', $progress->devotionalPlan->slug) }}" 
                                       class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                                        Continue Reading
                                    </a>
                                    <a href="{{ route('devotionals.show', $progress->devotionalPlan->slug) }}" 
                                       class="px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                        Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Available Plans -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">✨ Available Devotional Plans</h3>
                
                @if($activePlans->isEmpty())
                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <p class="text-gray-500">No devotional plans available yet. Check back soon!</p>
                    </div>
                @else
                    <div class="grid md:grid-cols-3 gap-6">
                        @foreach($activePlans as $plan)
                            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                    {{ $plan->name }}
                                </h4>
                                
                                @if($plan->description)
                                    <p class="text-sm text-gray-600 mb-4">
                                        {{ Str::limit($plan->description, 100) }}
                                    </p>
                                @endif

                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $plan->duration_days }} {{ Str::plural('day', $plan->duration_days) }}
                                </div>

                                <a href="{{ route('devotionals.show', $plan->slug) }}" 
                                   class="block text-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                                    View Plan
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Completed Devotionals -->
            @if($completed->isNotEmpty())
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">🎉 Completed Devotionals</h3>
                    <div class="bg-white rounded-lg shadow-md divide-y">
                        @foreach($completed as $progress)
                            <div class="p-4 flex justify-between items-center hover:bg-gray-50">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $progress->devotionalPlan->name }}</h4>
                                    <p class="text-sm text-gray-500">Completed {{ $progress->completed_at->diffForHumans() }}</p>
                                </div>
                                <a href="{{ route('devotionals.show', $progress->devotionalPlan->slug) }}" 
                                   class="text-sm text-blue-600 hover:text-blue-800">
                                    View Again
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
