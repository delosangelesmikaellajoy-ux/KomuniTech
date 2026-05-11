@props([
    'variant' => 'primary', // primary, success, error, warning, info, neutral
    'size' => 'md', // sm, md, lg
])

@php
    $variantClasses = match($variant) {
        'primary' => 'bg-primary-100 text-primary-800',
        'success' => 'bg-success-100 text-success-800',
        'error' => 'bg-error-100 text-error-800',
        'warning' => 'bg-warning-100 text-warning-800',
        'info' => 'bg-info-100 text-info-800',
        'neutral' => 'bg-neutral-100 text-neutral-800',
        default => 'bg-primary-100 text-primary-800',
    };

    $sizeClasses = match($size) {
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-3 py-1 text-sm',
        'lg' => 'px-4 py-2 text-base',
        default => 'px-3 py-1 text-sm',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full font-medium $variantClasses $sizeClasses"]) }}>
    {{ $slot }}
</span>
