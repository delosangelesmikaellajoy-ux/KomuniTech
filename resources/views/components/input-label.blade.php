@props(['value'])

<label {{ $attributes->merge([
    'class' => '
        block 
        font-semibold 
        text-sm 
        text-[#0B1F3A] 
        dark:text-[#oooooo]
        tracking-wide 
    '
]) }}>
    {{ $value ?? $slot }}
</label>
