@props(['verse', 'size' => 'md'])

@php
    $sizeClasses = [
        'sm' => 'w-4 h-4',
        'md' => 'w-6 h-6',
        'lg' => 'w-8 h-8',
    ];
    $iconSize = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<button
    onclick="toggleFavorite({{ $verse->id }}, this)"
    data-verse-id="{{ $verse->id }}"
    data-is-favorited="{{ auth()->check() && auth()->user()->hasFavorited($verse) ? 'true' : 'false' }}"
    class="favorite-button transition-all duration-200 hover:scale-110 focus:outline-none"
    title="{{ auth()->check() && auth()->user()->hasFavorited($verse) ? 'Remove from favorites' : 'Add to favorites' }}"
>
    <svg 
        class="{{ $iconSize }} favorite-icon transition-colors"
        fill="{{ auth()->check() && auth()->user()->hasFavorited($verse) ? 'currentColor' : 'none' }}"
        stroke="currentColor" 
        viewBox="0 0 24 24"
        style="color: {{ auth()->check() && auth()->user()->hasFavorited($verse) ? '#ef4444' : '#9ca3af' }}"
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
    </svg>
</button>

@once
@push('scripts')
<script>
function toggleFavorite(verseId, button) {
    @guest
        alert('Please log in to favorite verses!');
        window.location.href = '{{ route("login") }}';
        return;
    @endguest

    const icon = button.querySelector('.favorite-icon');
    const isFavorited = button.dataset.isFavorited === 'true';

    fetch(`/favorites/${verseId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update button state
            button.dataset.isFavorited = data.is_favorited;
            
            // Update icon
            if (data.is_favorited) {
                icon.style.fill = 'currentColor';
                icon.style.color = '#ef4444';
                button.title = 'Remove from favorites';
                
                // Animate
                button.style.transform = 'scale(1.2)';
                setTimeout(() => button.style.transform = 'scale(1)', 200);
            } else {
                icon.style.fill = 'none';
                icon.style.color = '#9ca3af';
                button.title = 'Add to favorites';
            }

            // Show toast notification
            showToast(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred. Please try again.', 'error');
    });
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
@endpush
@endonce
