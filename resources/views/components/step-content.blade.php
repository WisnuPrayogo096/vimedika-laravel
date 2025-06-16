@props([
    'step' => 1,
    'active' => false,
    'title' => '',
    'description' => '',
    'showRequiredNote' => false,
])

<div id="step-content-{{ $step }}" class="step-content {{ $active ? '' : 'hidden' }}"
    data-step="{{ $step }}">
    @if ($title)
        <h3 class="mb-4 text-lg font-medium leading-none text-gray-900 dark:text-white">{{ $title }}</h3>
    @endif

    @if ($description)
        <p class="mb-4 italic">{{ $description }}</p>
    @endif

    @if ($showRequiredNote)
        <p class="mb-4 italic">Tanda <span class="text-red-600 font-bold dark:text-red-400">*</span> wajib diisi</p>
    @endif

    {{ $slot }}
</div>
