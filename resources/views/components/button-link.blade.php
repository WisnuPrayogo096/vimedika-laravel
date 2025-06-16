@props([
    'href' => null,
    'variant' => 'primary',
])

@php
    $variants = [
        'primary' =>
            'text-white whitespace-nowrap bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800',
        'update' =>
            'bg-white border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-4 focus:ring-blue-300 dark:text-blue-500 dark:border-blue-500 dark:bg-eerie-black dark:hover:bg-eerie-black/70 dark:focus:ring-blue-800',
        'delete' =>
            'bg-white whitespace-nowrap border border-red-600 text-[#DB2829] hover:bg-red-50 focus:ring-4 focus:ring-red-300 dark:text-red-500 dark:border-red-500 dark:bg-eerie-black dark:hover:bg-eerie-black/70 dark:focus:ring-red-800',
        'outline' =>
            'bg-white whitespace-nowrap border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-4 focus:ring-blue-300 dark:text-blue-500 dark:border-blue-500 dark:bg-eerie-black dark:hover:bg-eerie-black/70 dark:focus:ring-blue-800',
    ];

    $class = $variants[$variant] ?? $variants['primary'];
@endphp

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' => "{$class} font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none gap-6 w-max h-max",
    ]) }}>
    {{ $slot }}
</a>
