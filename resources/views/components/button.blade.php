@props([
    'variant' => 'primary',
])

@php
    $variants = [
        'primary' =>
            'text-white disabled:opacity-70 whitespace-nowrap bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800',
        'update' =>
            'bg-white disabled:opacity-70 whitespace-nowrap border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-4 focus:ring-blue-300 dark:text-blue-500 dark:border-blue-500 dark:bg-eerie-black dark:hover:bg-eerie-black/70 dark:focus:ring-blue-800',
        'delete' =>
            'bg-white disabled:opacity-70 whitespace-nowrap border border-red-600 text-red-600 hover:bg-red-50 focus:ring-4 focus:ring-red-300 dark:text-red-500 dark:border-red-500 dark:bg-eerie-black dark:hover:bg-eerie-black/70 dark:focus:ring-red-800',
        'outline' =>
            'bg-white disabled:opacity-70 whitespace-nowrap border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-4 focus:ring-blue-300 dark:text-blue-500 dark:border-blue-500 dark:bg-eerie-black dark:hover:bg-eerie-black/70 dark:focus:ring-blue-800',
        'generate_nip' =>
            'bg-white disabled:opacity-70 whitespace-nowrap border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-4 focus:ring-blue-300 dark:text-blue-500 dark:border-blue-500 dark:bg-eerie-black dark:hover:bg-eerie-black/70 dark:focus:ring-blue-800',
    ];

    $class = $variants[$variant] ?? $variants['primary'];
@endphp

<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => "{$class} font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none justify-center h-max w-max disabled:cursor-not-allowed",
    ]) }}>
    {{ $slot }}
</button>
