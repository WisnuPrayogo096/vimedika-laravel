@props([
    'currentStep' => 1,
    'totalSteps' => 1,
    'btnSubmitId' => null,
    'showBack' => true,
    'backStep' => null,
    'nextStep' => null,
    'backLabel' => 'Kembali',
    'nextLabel' => 'Lanjutkan',
    'submitLabel' => 'Simpan',
    'isLastStep' => false,
    'nextValidation' => null,
    'backValidation' => null,
])

<div class="flex gap-4 justify-between mt-8">
    @if ($showBack || $backStep)
        <x-button class="back-step" data-back-step="{{ $backStep }}" data-validate="{{ $backValidation }}"
            type="button" variant="outline">
            {{ $backLabel }}
        </x-button>
    @endif

    <div class="flex gap-4 ml-auto">
        @if ($isLastStep)
            <x-button type="submit" id="{{ $btnSubmitId ?? '' }}" variant="primary">
                {{ $submitLabel }}
            </x-button>
        @else
            <x-button class="next-step" data-next-step="{{ $nextStep }}" data-validate="{{ $nextValidation }}"
                type="button" variant="outline">
                {{ $nextLabel }}
            </x-button>
        @endif
    </div>
</div>
