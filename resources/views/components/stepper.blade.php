@props([
    'stepId',
    'steps' => [],
    'currentStep' => 1,
    'color' => 'blue',
    'darkColor' => 'blue',
    'validationFunction' => null,
])

@php
    $colors = [
        'blue' => [
            'light' => 'bg-blue-600',
            'dark' => 'bg-blue-800',
        ],
        'green' => [
            'light' => 'bg-green-600',
            'dark' => 'bg-green-800',
        ],
        'red' => [
            'light' => 'bg-red-600',
            'dark' => 'bg-red-800',
        ],
        'indigo' => [
            'light' => 'bg-indigo-600',
            'dark' => 'bg-indigo-800',
        ],
        'purple' => [
            'light' => 'bg-purple-600',
            'dark' => 'bg-purple-800',
        ],
        'pink' => [
            'light' => 'bg-pink-600',
            'dark' => 'bg-pink-800',
        ],
    ];

    $activeColor = $colors[$color]['light'] ?? $colors['blue']['light'];
    $activeDarkColor = $colors[$darkColor]['dark'] ?? $colors['blue']['dark'];
@endphp
<div class="stepper-container" id="{{ $stepId }}">
    <ol class="flex items-center w-full mb-6 sm:mb-5 stepper-indicators">
        @foreach ($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber <= $currentStep;
                $isLast = $stepNumber === count($steps);

                $circleClasses = $isActive
                    ? "{$activeColor} dark:{$activeDarkColor} text-white"
                    : 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400';

                $lineClasses =
                    $isActive && !$isLast
                        ? "after:border-{$color}-600 dark:after:border-{$darkColor}-800"
                        : 'after:border-gray-100 dark:after:border-gray-700';
            @endphp

            <li data-step="{{ $stepNumber }}"
                @if ($validationFunction) data-validate="{{ $validationFunction }}" @endif
                class="steps hover:cursor-pointer flex items-center @if (!$isLast) w-full after:content-[''] after:w-full after:h-1 after:border-b-[4px] after:inline-block {{ $lineClasses }} @endif">
                <div
                    class="flex items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 shrink-0 {{ $circleClasses }}">
                    @if (isset($step['icon']))
                        <i class="{{ $step['icon'] }}"></i>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
    {{ $content }}
</div>
