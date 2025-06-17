@props(['label' => 'Label', 'value' => '', 'required' => false, 'disabled' => false, 'id'])

<div class="w-full">
    <label for="{{ $id }}" class="mb-2 block font-medium text-white">
        {{ $label }}
        @if ($required)
            <span class="text-red-600">*</span>
        @endif
    </label>
    <div class="flex gap-1 flex-col">
        <input id="{{ $id }}" {{ $disabled ? 'disabled' : '' }}
            value="{{ old($attributes->get('name'), $value) }}" {!! $attributes->merge([
                'type' => 'text',
                'class' =>
                    'bg-transparent disabled:opacity-60 disabled:cursor-not-allowed border border-gray-300 text-white rounded-lg focus:outline-none focus:shadow-md block w-full px-4 py-2',
            ]) !!}
            {{ $required ? 'required' : '' }} />
    </div>

    @error($attributes->get('name'))
        <p class="mt-2 text-red-600 error-message">
            {{ $message }}
        </p>
    @enderror
</div>
