@props([
    'label' => 'Label',
    'value' => '',
    'required' => false,
    'isLabel' => true,
    'disabled' => false,
    'id',
])

<div class="w-full">
    @if ($isLabel)
        <label for="{{ $id }}" class="mb-2 block font-medium text-chinese-black dark:text-white">
            {{ $label }}
            @if ($required)
                <span class="text-red-600 dark:text-red-400">*</span>
            @endif
        </label>
    @endif
    <div class="flex gap-1 flex-col">
        <select id="{{ $id }}" {{ $disabled ? 'disabled' : '' }}
            value="{{ old($attributes->get('name'), $value) }}" {!! $attributes->merge([
                'type' => 'text',
                'class' =>
                    'bg-gray-50 border border-gray-300 text-chinese-black rounded-lg focus:outline-none focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-eerie-black dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600',
            ]) !!}
            {{ $required ? 'required' : '' }}>
            {{ $slot }}
        </select>
    </div>

    @error($attributes->get('name'))
        <p class="mt-2 text-red-600 dark:text-red-500 error-message">
            {{ $message }}
        </p>
    @enderror
</div>
