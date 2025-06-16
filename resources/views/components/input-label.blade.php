@props(['label' => 'Label', 'value' => '', 'required' => false, 'disabled' => false, 'id'])

<div class="w-full">
    <label for="{{ $id }}" class="mb-2 block font-medium text-gray-900 dark:text-white">
        {{ $label }}
        @if ($required)
            <span class="text-red-600 dark:text-red-400">*</span>
        @endif
    </label>
    <div class="flex gap-1 flex-col">
        <input id="{{ $id }}" {{ $disabled ? 'disabled' : '' }}
            value="{{ old($attributes->get('name'), $value) }}" {!! $attributes->merge([
                'type' => 'text',
                'class' =>
                    'bg-gray-50 disabled:bg-gray-50 disabled:opacity-60 disabled:cursor-not-allowed border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:ring-blue-600 focus:border-blue-600 block w-full px-2.5 py-2 dark:bg-eerie-black dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600',
            ]) !!}
            {{ $required ? 'required' : '' }} />
    </div>

    @error($attributes->get('name'))
        <p class="mt-2 text-red-600 dark:text-red-500 error-message">
            {{ $message }}
        </p>
    @enderror
</div>
