@props([
    'variant' => 'primary', // primary, secondary, success, error, warning, ghost
    'size' => 'md', // xs, sm, md, lg
    'icon' => null,
    'disabled' => false,
    'loading' => false,
    'fullWidth' => false,
    'type' => 'button',
    'href' => null, // For anchor links
    'target' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    // Size classes
    $sizeClasses = match($size) {
        'xs' => 'px-2 py-1 text-xs rounded-md',
        'sm' => 'px-3 py-2 text-sm rounded-lg',
        'md' => 'px-4 py-2 text-base rounded-lg',
        'lg' => 'px-6 py-3 text-lg rounded-xl',
        default => 'px-4 py-2 text-base rounded-lg',
    };

    // Variant classes
    $variantClasses = match($variant) {
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 active:bg-primary-800 focus:ring-primary-500',
        'secondary' => 'bg-neutral-200 text-neutral-900 hover:bg-neutral-300 active:bg-neutral-400 focus:ring-neutral-500',
        'success' => 'bg-success-600 text-white hover:bg-success-700 active:bg-success-800 focus:ring-success-500',
        'error' => 'bg-error-600 text-white hover:bg-error-700 active:bg-error-800 focus:ring-error-500',
        'warning' => 'bg-warning-600 text-white hover:bg-warning-700 active:bg-warning-800 focus:ring-warning-500',
        'ghost' => 'bg-transparent text-neutral-700 hover:bg-neutral-100 active:bg-neutral-200 focus:ring-neutral-300 border border-neutral-300',
        default => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500',
    };

    $widthClasses = $fullWidth ? 'w-full' : '';
    $isLink = $href !== null;
@endphp

@if($isLink)
    <a 
        href="{{ $href }}"
        {{ $attributes->merge([
            'class' => "$baseClasses $sizeClasses $variantClasses $widthClasses no-underline",
            'target' => $target,
        ]) }}
    >
        @if($icon)
            <i class="{{ $icon }} mr-2"></i>
        @endif
        <span>{{ $slot }}</span>
    </a>
@else
    <button 
        type="{{ $type }}"
        {{ $attributes->merge(['class' => "$baseClasses $sizeClasses $variantClasses $widthClasses"]) }}
        @disabled($disabled || $loading)
    >
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon)
            <i class="{{ $icon }} mr-2"></i>
        @endif
        <span>{{ $slot }}</span>
    </button>
@endif
