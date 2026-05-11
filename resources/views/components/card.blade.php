@props([
    'shadow' => 'md', // none, xs, sm, md, lg
    'padding' => 'md', // none, xs, sm, md, lg
    'border' => false,
])

@php
    $shadowClasses = match($shadow) {
        'none' => 'shadow-none',
        'xs' => 'shadow-xs',
        'sm' => 'shadow-sm',
        'md' => 'shadow-base',
        'lg' => 'shadow-lg',
        default => 'shadow-base',
    };

    $paddingClasses = match($padding) {
        'none' => '',
        'xs' => 'p-2',
        'sm' => 'p-3',
        'md' => 'p-6',
        'lg' => 'p-8',
        default => 'p-6',
    };

    $borderClasses = $border ? 'border border-neutral-200' : '';
@endphp

<div {{ $attributes->merge(['class' => "bg-white rounded-xl $shadowClasses $paddingClasses $borderClasses"]) }}>
    {{ $slot }}
</div>
