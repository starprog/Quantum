@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <div style="padding: 0 1rem;">
        <div style="margin-bottom: 1rem;">
            <h3 style="font-size: 1.125rem; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 0.5rem;">
                {{ $title }}
            </h3>
        </div>
        <div style="margin-top: 0.5rem;">
            <p style="font-size: 0.875rem; color: #6b7280; line-height: 1.5;">
                {{ $description }}
            </p>
        </div>
    </div>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">
            <div style="padding: 1.5rem; background: rgba(249, 250, 251, 0.5); border-radius: {{ isset($actions) ? '0.5rem 0.5rem 0 0' : '0.5rem' }}; border: 2px solid #f3f4f6; border-bottom: {{ isset($actions) ? 'none' : '2px solid #f3f4f6' }};">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem; padding: 1rem 1.5rem; background: white; border: 2px solid #f3f4f6; border-top: none; border-radius: 0 0 0.5rem 0.5rem;">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
