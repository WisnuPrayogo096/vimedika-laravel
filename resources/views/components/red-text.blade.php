@props([
    'tag' => 'span',
    'weight' => 'normal',
    'size' => 'base',
])

<{{ $tag }} {{ $attributes->merge([
    'class' => implode(' ', [
        'text-red-600 dark:text-red-400',
        'font-' . $weight,
        'text-' . $size,
    ])
]) }}>
    {{ $slot }}
</{{ $tag }}>