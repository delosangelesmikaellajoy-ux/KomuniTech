@props(['align' => 'left'])

@php
    $alignClass = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        'left' => 'text-left',
        default => 'text-left',
    };
@endphp

<td class="px-4 py-3 text-neutral-700 {{ $alignClass }} {{ $attributes->get('class') ?? '' }}">
    {{ $slot }}
</td>
