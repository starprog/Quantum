<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit: {{ $plan->name }}
            </h2>
            <a href="{{ route('admin.devotionals.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Plans
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-6">
                
                <!-- Left: Plan Details -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Plan Details</h3>
                        
                        <form method="POST" action="{{ route('admin.devotionals.update', $plan->id) }}" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    value="{{ old('name', $plan->name) }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea 
                                    name="description" 
                                    rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                >{{ old('description', $plan->description) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                                <input 
                                    type="number" 
                                    name="duration_days" 
                                    value="{{ old('duration_days', $plan->duration_days) }}"
                                    min="1"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                >
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="is_active" 
                                        value="1"
                                        {{ old('is_active', $plan->is_active) ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 rounded"
                                    >
                                    <span class="ml-2 text-sm">Active</span>
                                </label>
                            </div>

                            <button 
                                type="submit" 
                                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm"
                            >
                                Update Details
                            </button>
                        </form>

                        <div class="mt-6 pt-6 border-t">
                            <div class="text-sm text-gray-600 space-y-2">
                                <p><strong>Progress:</strong> {{ $plan->planVerses->count() }} / {{ $plan->duration_days }} days configured</p>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $plan->completion_percentage }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <form method="POST" action="{{ route('admin.devotionals.destroy', $plan->id) }}" onsubmit="return confirm('Delete this entire devotional plan? This cannot be undone!');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg font-medium text-sm">
                                    Delete Plan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right: Day-by-Day Verse Assignment -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Assign Verses to Days
                        </h3>

                        <div class="space-y-4">
                            @for($day = 1; $day <= $plan->duration_days; $day++)
                                @php
                                    $assignedVerse = $plan->planVerses->firstWhere('day_number', $day);
                                @endphp
                                
                                <div class="border rounded-lg p-4 {{ $assignedVerse ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                                    <div class="flex justify-between items-start mb-3">
                                        <h4 class="font-semibold text-gray-900">Day {{ $day }}</h4>
                                        @if($assignedVerse)
                                            <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded">✓ Configured</span>
                                        @else
                                            <span class="text-xs px-2 py-1 bg-gray-200 text-gray-600 rounded">Not set</span>
                                        @endif
                                    </div>

                                    @if($assignedVerse)
                                        <div class="bg-white rounded p-3 mb-3">
                                            <p class="text-sm font-medium text-gray-900 mb-1">{{ $assignedVerse->verse->reference }}</p>
                                            <p class="text-sm text-gray-700 mb-2">{{ Str::limit($assignedVerse->verse->verse, 150) }}</p>
                                            @if($assignedVerse->reflection_text)
                                                <p class="text-xs text-gray-600 italic mt-2 border-t pt-2">
                                                    Reflection: {{ Str::limit($assignedVerse->reflection_text, 100) }}
                                                </p>
                                            @endif
                                        </div>
                                        <button 
                                            onclick="editDay({{ $day }}, {{ $assignedVerse->verse_id }}, '{{ addslashes($assignedVerse->reflection_text ?? '') }}')"
                                            class="text-sm text-blue-600 hover:text-blue-800 mr-3"
                                        >
                                            Edit
                                        </button>
                                        <button 
                                            onclick="removeDay({{ $day }})"
                                            class="text-sm text-red-600 hover:text-red-800"
                                        >
                                            Remove
                                        </button>
                                    @else
                                        <button 
                                            onclick="assignDay({{ $day }})"
                                            class="text-sm text-blue-600 hover:text-blue-800 font-medium"
                                        >
                                            + Assign Verse
                                        </button>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verse Selection Modal -->
    <div id="verseModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" onclick="if(event.target === this) closeModal()">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden" onclick="event.stopPropagation()">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold" id="modalTitle">Assign Verse to Day</h3>
            </div>
            
            <div class="p-6 overflow-y-auto" style="max-height: 50vh;">
                <div class="mb-4">
                    <input 
                        type="text" 
                        id="verseSearch" 
                        placeholder="Search by reference or content..."
                        class="w-full px-4 py-2 border rounded-lg"
                        onkeyup="filterVerses()"
                    >
                </div>

                <div id="verseList" class="space-y-2 max-h-64 overflow-y-auto mb-4">
                    @foreach($availableVerses as $verse)
                        <div class="verse-item cursor-pointer border rounded p-3 hover:bg-blue-50"
                             onclick="selectVerse({{ $verse->id }}, '{{ addslashes($verse->reference) }}')"
                             data-ref="{{ strtolower($verse->reference) }}"
                             data-text="{{ strtolower($verse->verse) }}">
                            <p class="font-medium text-sm">{{ $verse->reference }}</p>
                            <p class="text-xs text-gray-600">{{ Str::limit($verse->verse, 100) }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Reflection Text (Optional)</label>
                    <textarea 
                        id="reflectionText"
                        rows="3"
                        class="w-full px-3 py-2 border rounded-lg text-sm"
                        placeholder="Add a thought or reflection for this day..."
                    ></textarea>
                </div>

                <input type="hidden" id="selectedDay">
                <input type="hidden" id="selectedVerseId">
            </div>

            <div class="p-6 border-t flex justify-end gap-3">
                <button onclick="closeModal()" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Cancel</button>
                <button onclick="saveAssignment()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save</button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const planId = {{ $plan->id }};
        const csrfToken = '{{ csrf_token() }}';

        function assignDay(day) {
            document.getElementById('selectedDay').value = day;
            document.getElementById('selectedVerseId').value = '';
            document.getElementById('reflectionText').value = '';
            document.getElementById('modalTitle').textContent = `Assign Verse to Day ${day}`;
            document.getElementById('verseModal').classList.remove('hidden');
        }

        function editDay(day, verseId, reflection) {
            document.getElementById('selectedDay').value = day;
            document.getElementById('selectedVerseId').value = verseId;
            document.getElementById('reflectionText').value = reflection;
            document.getElementById('modalTitle').textContent = `Edit Day ${day}`;
            document.getElementById('verseModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('verseModal').classList.add('hidden');
        }

        function selectVerse(verseId, reference) {
            document.getElementById('selectedVerseId').value = verseId;
            document.querySelectorAll('.verse-item').forEach(item => {
                item.classList.remove('bg-blue-100', 'border-blue-500');
            });
            event.currentTarget.classList.add('bg-blue-100', 'border-blue-500');
        }

        function filterVerses() {
            const search = document.getElementById('verseSearch').value.toLowerCase();
            document.querySelectorAll('.verse-item').forEach(item => {
                const ref = item.dataset.ref;
                const text = item.dataset.text;
                item.style.display = (ref.includes(search) || text.includes(search)) ? '' : 'none';
            });
        }

        function saveAssignment() {
            const day = document.getElementById('selectedDay').value;
            const verseId = document.getElementById('selectedVerseId').value;
            const reflection = document.getElementById('reflectionText').value;

            if (!verseId) {
                alert('Please select a verse');
                return;
            }

            fetch(`/admin/devotionals/${planId}/assign-verse`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    day_number: day,
                    verse_id: verseId,
                    reflection_text: reflection
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to assign verse'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
        }

        function removeDay(day) {
            if (!confirm(`Remove verse from Day ${day}?`)) return;

            fetch(`/admin/devotionals/${planId}/remove-verse/${day}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
    @endpush
</x-app-layout>
