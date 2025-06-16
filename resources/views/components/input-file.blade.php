@props(['mime', 'name', 'id', 'label' => 'Label', 'mimeLabel' => null, 'required' => false])
<label for="{{ $id }}"
    class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-eerie-black dark:border-gray-700">
    <div class="flex flex-col items-center justify-center pt-5 pb-6">
        <i class="fa-solid fa-file-image text-3xl mb-4 text-gray-400"></i>
        <p class="mb-2 text-base text-gray-500 font-semibold dark:text-gray-300">
            {{ $label }}
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $mimeLabel ?? $mime }}
            {{ $required ? '(Wajib diisi)' : '' }}</p>
        <p id="{{ $id }}-filename" class="text-sm mt-2 text-gray-600 dark:text-gray-300">
            Tidak ada file yang dipilih
        </p>
    </div>
    <input id="{{ $id }}" name="{{ $name }}" type="file" class="hidden" accept="{{ $mime }}"
        {{ $required ? 'required' : '' }}>
</label>
@error($attributes->get('name'))
    <p class="mt-2 text-red-600 dark:text-red-500 error-message">
        {{ $message }}
    </p>
@enderror
