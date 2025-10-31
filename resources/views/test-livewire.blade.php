<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Livewire Test
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('test-counter')
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== LIVEWIRE DIAGNOSTIC ===');
            console.log('window.Livewire exists?', typeof window.Livewire !== 'undefined');
            console.log('Livewire object:', window.Livewire);
            
            if (typeof window.Livewire !== 'undefined') {
                console.log('✅ Livewire is loaded');
                console.log('Livewire version:', window.Livewire.version || 'unknown');
            } else {
                console.error('❌ Livewire is NOT loaded!');
            }
            
            // Check if @livewireScripts was rendered
            const livewireScripts = document.querySelector('script[src*="livewire"]');
            console.log('Livewire script tag found?', livewireScripts !== null);
            if (livewireScripts) {
                console.log('Livewire script src:', livewireScripts.src);
            }
        });
    </script>
    @endpush
</x-app-layout>
