@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-2 pt-1 border-b-2 border-[#6BB1F3] text-[#0B1F3A] text-base font-bold leading-5 focus:outline-none transition duration-150 ease-in-out'
    : 'inline-flex items-center px-2 pt-1 border-b-2 border-transparent text-[#1E3A8A] text-base font-semibold leading-5 hover:text-[#0B1F3A] hover:border-[#A2D3F9] focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
