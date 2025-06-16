@props([
    'percent' => 100,
    'size' => 60,
    'stroke' => 4,
    'color' => 'text-blue-600',
    'bgColor' => 'text-gray-200 dark:text-gray-700',
])

@php
    $percent = (float) $percent;
    $radius = 15.915;
    $circumference = 2 * pi() * $radius;
    $offset = $circumference * (1 - $percent / 100);
@endphp

<style>
    @keyframes draw-circle-{{ $percent }} {
        from {
            stroke-dashoffset: {{ $circumference }};
        }

        to {
            stroke-dashoffset: {{ $offset }};
        }
    }
</style>


<div style="width: {{ $size }}px; height: {{ $size }}px;" class="relative">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
        <circle class="{{ $bgColor }}" stroke-width="{{ $stroke }}" stroke="currentColor" fill="transparent"
            r="{{ $radius }}" cx="18" cy="18" />
        <circle class="{{ $color }}" stroke-width="{{ $stroke }}" stroke-dasharray="{{ $circumference }}"
            stroke-dashoffset="{{ $offset }}" stroke-linecap="butt" stroke="currentColor" fill="transparent"
            r="{{ $radius }}" cx="18" cy="18"
            style="animation: draw-circle 1s ease-out forwards;" />
    </svg>
    <div class="absolute inset-0 flex items-center justify-center">
        <span class="text-sm font-medium {{ $color }} dark:text-white">{{ $percent }}%</span>
    </div>
</div>
