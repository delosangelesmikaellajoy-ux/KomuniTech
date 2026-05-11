@props([
    'type' => 'text',
    'placeholder' => '',
    'label' => null,
    'hint' => null,
    'error' => null,
    'required' => false,
])

@php
    $errorClass = $error ? 'border-error-500 focus:ring-error-500' : 'border-neutral-300 focus:ring-primary-500';
@endphp

<div class="mb-4">
    @if($label)
        <label class="block text-sm font-medium text-neutral-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-error-600">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => "w-full px-4 py-2 border rounded-lg text-base text-neutral-900 placeholder-neutral-400 transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 $errorClass"]) }}
        @required($required)
    />

    @if($error)
        <p class="mt-1 text-sm text-error-600">{{ $error }}</p>
    @elseif($hint)
        <p class="mt-1 text-sm text-neutral-500">{{ $hint }}</p>
    @endif
</div>
