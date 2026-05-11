@props([
    'variant' => 'info', // info, success, warning, error
    'icon' => null,
    'dismissible' => true,
])

@php
    $variantClasses = match($variant) {
        'success' => 'bg-success-50 border-success-200 text-success-800',
        'error' => 'bg-error-50 border-error-200 text-error-800',
        'warning' => 'bg-warning-50 border-warning-200 text-warning-800',
        'info' => 'bg-info-50 border-info-200 text-info-800',
        default => 'bg-info-50 border-info-200 text-info-800',
    };

    $id = 'alert-' . uniqid();
@endphp

<div
    id="{{ $id }}"
    role="alert"
    {{ $attributes->merge(['class' => "border rounded-lg p-4 flex items-start gap-3 $variantClasses"]) }}
>
    @if($icon)
        <span class="flex-shrink-0">{{ $icon }}</span>
    @endif

    <div class="flex-1">
        {{ $slot }}
    </div>

    @if($dismissible)
        <button
            type="button"
            onclick="document.getElementById('{{ $id }}').remove()"
            class="flex-shrink-0 inline-flex text-neutral-400 hover:text-neutral-500 focus:outline-none focus:text-neutral-500 transition ease-in-out duration-150"
        >
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    @endif
</div>
