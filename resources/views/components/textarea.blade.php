@props(['label' => 'Label', 'value' => '', 'disabled' => false, 'id', 'rows' => 4, 'required' => false])

<div>
    <label for="{{ $id }}" class="mb-2 block font-medium text-gray-900 dark:text-white">
        {{ $label }}
        @if ($required)
            <span class="text-red-600 dark:text-red-400">*</span>
        @endif
    </label>
    <textarea id="{{ $id }}" rows="{{ $rows }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            'bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:ring-blue-600 focus:border-blue-600 block w-full px-2.5 py-2 dark:bg-eerie-black dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600',
    ]) !!}
        {{ $required ? 'required' : '' }}>{{ old($attributes->get('name'), $value) }}</textarea>

    @error($attributes->get('name'))
        <p class="mt-2 text-red-600 dark:text-red-500 error-message">
            {{ $message }}
        </p>
    @enderror
</div>
