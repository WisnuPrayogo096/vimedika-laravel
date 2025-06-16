@props([
    'label' => 'Label',
    'name' => '',
    'value' => '',
    'disabled' => false,
    'id' => '',
    'options' => [],
    'inline' => true,
    'required' => false,
])

<div>
    <label for="{{ $id }}" class="mb-2 block font-medium text-chinese-black dark:text-white">
        {{ $label }}
        @if ($required)
            <span class="text-red-600 dark:text-red-400">*</span>
        @endif
    </label>

    <div @class([
        'space-y-2' => !$inline,
        'flex items-center space-x-4' => $inline,
    ])>
        @foreach($options as $key => $optionLabel)
            <label class="inline-flex items-center">
                <input
                    type="radio"
                    id="{{ $id }}-{{ $key }}"
                    name="{{ $name }}"
                    value="{{ $key }}"
                    {{ old($name, $value) == $key ? 'checked' : '' }}
                    {{ $disabled ? 'disabled' : '' }}
                    class="text-blue-600 focus:ring-blue-600 border-gray-300 dark:bg-eerie-black dark:border-gray-700"
                >
                <span class="ml-2 dark:text-white">{{ $optionLabel }}</span>
            </label>
        @endforeach
    </div>

    @error($name)
        <p class="mt-2 text-red-600 dark:text-red-500 error-message">
            {{ $message }}
        </p>
    @enderror
</div>