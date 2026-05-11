@props([
    'striped' => true,
    'hover' => true,
])

@php
    $rowClasses = 'border-b border-neutral-200';
    $rowHoverClasses = $hover ? 'hover:bg-neutral-50 transition duration-150' : '';
    $rowStripedClasses = $striped ? 'odd:bg-white even:bg-neutral-50' : 'bg-white';
@endphp

<div class="overflow-x-auto rounded-lg border border-neutral-200">
    <table class="w-full text-base">
        {{ $slot }}
    </table>
</div>
