@props(['align' => 'left'])

@php
    $alignClass = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        'left' => 'text-left',
        default => 'text-left',
    };
@endphp

<th class="px-4 py-3 font-semibold {{ $alignClass }} {{ $attributes->get('class') ?? '' }}">
    {{ $slot }}
</th>
