<!-- Cross-References Component -->
@props(['book', 'chapter', 'verse'])

@php
    $references = \App\Models\CrossReference::getBidirectional($book, $chapter, $verse);
    $types = \App\Models\CrossReference::getTypes();
@endphp

@if($references->count() > 0)
    <div {{ $attributes->merge(['class' => 'mt-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-100']) }}>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                Cross-References
                <span class="ml-2 text-sm text-gray-600">({{ $references->count() }})</span>
            </h3>
            <a href="{{ route('cross-references.show', ['book' => $book, 'chapter' => $chapter, 'verse' => $verse]) }}" 
               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                View All →
            </a>
        </div>

        <div class="space-y-2">
            @foreach($references->take(5) as $ref)
                <div class="flex items-start bg-white rounded-md p-3 hover:shadow-sm transition-shadow">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-{{ $types[$ref->type]['color'] }}-100 text-{{ $types[$ref->type]['color'] }}-800">
                            {{ $types[$ref->type]['label'] }}
                        </span>
                    </div>
                    <div class="ml-3 flex-1">
                        <a href="/bible-verse?book={{ $ref->to_book }}&chapter={{ $ref->to_chapter }}&verse={{ $ref->to_verse }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            {{ $ref->to_reference }}
                        </a>
                        @if($ref->note)
                            <p class="text-gray-600 text-sm mt-1">{{ Str::limit($ref->note, 80) }}</p>
                        @endif
                    </div>
                    <a href="{{ route('cross-references.show', ['book' => $ref->to_book, 'chapter' => $ref->to_chapter, 'verse' => $ref->to_verse]) }}" 
                       class="ml-2 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>

        @if($references->count() > 5)
            <div class="mt-4 text-center">
                <a href="{{ route('cross-references.show', ['book' => $book, 'chapter' => $chapter, 'verse' => $verse]) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                    View All {{ $references->count() }} Cross-References
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
@endif
