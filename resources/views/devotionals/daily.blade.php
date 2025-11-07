<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $plan->name }} - Day {{ $progress->current_day }}
            </h2>
            <a href="{{ route('devotionals.show', $plan->slug) }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Plan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Progress Bar -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Day {{ $progress->current_day }} of {{ $plan->duration_days }}</span>
                    <span>{{ $progress->progress_percentage }}% Complete</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all" style="width: {{ $progress->progress_percentage }}%"></div>
                </div>
            </div>

            <!-- Today's Verse -->
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg shadow-xl p-8 mb-6">
                <div class="text-center mb-6">
                    <p class="text-sm text-gray-600 mb-2">Today's Scripture</p>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">
                        {{ $todaysVerse->verse->reference }}
                    </h3>
                    
                    <div class="max-w-2xl mx-auto">
                        <p class="text-xl text-gray-800 leading-relaxed mb-6 font-serif">
                            "{{ $todaysVerse->verse->verse }}"
                        </p>
                    </div>

                    @if($todaysVerse->verse->category)
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ $todaysVerse->verse->category->name }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Reflection -->
            @if($todaysVerse->reflection_text)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">💭 Reflection</h4>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $todaysVerse->reflection_text }}
                    </p>
                </div>
            @endif

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <button 
                        onclick="completeDay()"
                        id="completeBtn"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 transition"
                    >
                        ✓ Mark Day {{ $progress->current_day }} Complete
                    </button>
                    
                    <x-favorite-button :verse="$todaysVerse->verse" size="lg" />
                </div>

                <div class="mt-4 pt-4 border-t text-center">
                    <p class="text-sm text-gray-500">
                        {{ $progress->days_remaining }} {{ Str::plural('day', $progress->days_remaining) }} remaining
                    </p>
                </div>
            </div>

            <!-- Encouragement -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                <p class="text-sm text-blue-800">
                    💪 <strong>Keep going!</strong> You're doing great. Take a moment to reflect on today's verse before continuing.
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function completeDay() {
            const btn = document.getElementById('completeBtn');
            btn.disabled = true;
            btn.innerHTML = 'Processing...';

            fetch(`/devotionals/{{ $plan->id }}/complete-day`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.completed) {
                        // Plan completed!
                        showCelebration();
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 3000);
                    } else {
                        // Move to next day
                        showSuccess(data.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                } else {
                    btn.disabled = false;
                    btn.innerHTML = '✓ Mark Day {{ $progress->current_day }} Complete';
                    alert(data.message || 'Error completing day');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.disabled = false;
                btn.innerHTML = '✓ Mark Day {{ $progress->current_day }} Complete';
                alert('An error occurred');
            });
        }

        function showSuccess(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50';
            toast.innerHTML = `
                <p class="font-semibold">${message}</p>
                <p class="text-sm">Loading next day...</p>
            `;
            document.body.appendChild(toast);
        }

        function showCelebration() {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white rounded-lg p-8 text-center max-w-md">
                    <div class="text-6xl mb-4">🎉</div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Congratulations!</h2>
                    <p class="text-gray-600 mb-4">You completed the entire devotional plan!</p>
                    <p class="text-sm text-gray-500">Redirecting...</p>
                </div>
            `;
            document.body.appendChild(modal);
        }
    </script>
    @endpush
</x-app-layout>
