<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $collection->name }}
            </h2>
            <div class="flex gap-2">
                @if($collection->canEdit())
                    <a href="{{ route('collections.edit', $collection->slug) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
                        Edit
                    </a>
                @endif
                <a href="{{ route('collections.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
                    ← Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Collection Info Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $collection->name }}</h1>
                        <p class="text-gray-600 mb-3">
                            Created by <span class="font-medium">{{ $collection->user->name }}</span> 
                            • {{ $collection->created_at->diffForHumans() }}
                        </p>
                        @if($collection->description)
                            <p class="text-gray-700 mt-2">{{ $collection->description }}</p>
                        @endif
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $collection->is_public ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $collection->is_public ? '🌍 Public' : '🔒 Private' }}
                    </span>
                </div>

                <div class="flex items-center gap-6 text-sm text-gray-600">
                    <span>📖 {{ $collection->verses->count() }} {{ Str::plural('verse', $collection->verses->count()) }}</span>
                    <button onclick="toggleLike()" id="like-btn" class="flex items-center gap-1 hover:text-red-600 transition">
                        <span id="like-icon">{{ auth()->user()->hasLikedCollection($collection) ? '❤️' : '🤍' }}</span>
                        <span id="likes-count">{{ $collection->likes()->count() }}</span> likes
                    </button>
                    <span>💬 {{ $collection->comments()->count() }} comments</span>
                    <a href="{{ route('social.profile', $collection->user) }}" class="hover:text-indigo-600">
                        View Profile →
                    </a>
                </div>

                @if($collection->is_public)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-2">Share this collection:</p>
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                value="{{ route('collections.show', $collection->slug) }}" 
                                readonly 
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-50"
                                id="shareUrl"
                            >
                            <button 
                                onclick="copyShareUrl()" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition"
                            >
                                Copy Link
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Verses List -->
            @if($collection->verses->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No verses in this collection yet</h3>
                    @if($collection->canEdit())
                        <p class="mt-2 text-sm text-gray-500">
                            Click "Edit" to add verses to this collection
                        </p>
                    @endif
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        @foreach($collection->verses as $index => $verse)
                            <div class="p-6 hover:bg-gray-50 transition">
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0 text-center">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $verse->category->name ?? 'Uncategorized' }}
                                            </span>
                                            <span class="text-sm font-semibold text-gray-700">
                                                {{ $verse->reference }}
                                            </span>
                                        </div>
                                        <p class="text-gray-800 text-lg leading-relaxed">
                                            {{ $verse->verse }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Comments Section -->
        @if($collection->is_public)
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Comments</h3>

                <!-- Add Comment Form -->
                <form onsubmit="addComment(event)" class="mb-6">
                    <textarea 
                        id="comment-input" 
                        rows="3" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                        placeholder="Share your thoughts..."
                        maxlength="500"
                    ></textarea>
                    <div class="flex justify-end mt-2">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Post Comment
                        </button>
                    </div>
                </form>

                <!-- Comments List -->
                <div id="comments-list" class="space-y-4">
                    @foreach($collection->comments()->with('user')->latest()->get() as $comment)
                    <div class="flex gap-3 pb-4 border-b border-gray-200" data-comment-id="{{ $comment->id }}">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-semibold">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                                    <span class="text-sm text-gray-500 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                @if($comment->user_id === auth()->id())
                                <button onclick="deleteComment({{ $comment->id }})" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                @endif
                            </div>
                            <p class="text-gray-700 mt-1">{{ $comment->comment }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('scripts')
    <script>
        const collectionId = {{ $collection->id }};
        let isLiked = {{ auth()->user()->hasLikedCollection($collection) ? 'true' : 'false' }};

        function toggleLike() {
            const url = isLiked 
                ? `/social/collections/${collectionId}/unlike`
                : `/social/collections/${collectionId}/like`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                isLiked = !isLiked;
                document.getElementById('like-icon').textContent = isLiked ? '❤️' : '🤍';
                document.getElementById('likes-count').textContent = data.likes_count;
            });
        }

        function addComment(event) {
            event.preventDefault();
            const input = document.getElementById('comment-input');
            const comment = input.value.trim();

            if (!comment) return;

            fetch(`/social/collections/${collectionId}/comment`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ comment })
            })
            .then(res => res.json())
            .then(data => {
                input.value = '';
                const commentsList = document.getElementById('comments-list');
                const commentHTML = `
                    <div class="flex gap-3 pb-4 border-b border-gray-200" data-comment-id="${data.comment.id}">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-semibold">
                            ${data.comment.user.name.charAt(0)}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-gray-900">${data.comment.user.name}</span>
                                    <span class="text-sm text-gray-500 ml-2">just now</span>
                                </div>
                                <button onclick="deleteComment(${data.comment.id})" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                            </div>
                            <p class="text-gray-700 mt-1">${data.comment.comment}</p>
                        </div>
                    </div>
                `;
                commentsList.insertAdjacentHTML('afterbegin', commentHTML);
            });
        }

        function deleteComment(commentId) {
            if (!confirm('Delete this comment?')) return;

            fetch(`/social/comments/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(() => {
                document.querySelector(`[data-comment-id="${commentId}"]`).remove();
            });
        }

        function copyShareUrl() {
            const input = document.getElementById('shareUrl');
            input.select();
            document.execCommand('copy');
            
            // Show feedback
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Copied!';
            button.classList.add('bg-green-600');
            button.classList.remove('bg-blue-600');
            
            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('bg-green-600');
                button.classList.add('bg-blue-600');
            }, 2000);
        }
    </script>
    @endpush
</x-app-layout>
