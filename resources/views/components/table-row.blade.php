@props(['striped' => true, 'hover' => true])

@php
    $stripedClass = $striped ? 'odd:bg-white even:bg-neutral-50' : 'bg-white';
    $hoverClass = $hover ? 'hover:bg-neutral-100 transition duration-150' : '';
@endphp

<tr class="{{ $stripedClass }} {{ $hoverClass }}">
    {{ $slot }}
</tr>
