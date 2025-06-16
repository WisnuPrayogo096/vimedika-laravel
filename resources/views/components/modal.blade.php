@props([
    'title' => 'Modal',
    'id',
])
<div id="{{ $id }}" tabindex="-1" aria-hidden="true"
    class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
    <div class="fixed inset-0 h-dvh w-screen bg-black opacity-30"></div>
    <div class="relative max-h-full w-full p-4">
        <div class="relative mx-auto rounded-lg bg-white shadow dark:bg-eerie-black sm:max-w-screen-sm">
            <div class="mx-auto flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>
                <button type="button"
                    class="end-2.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="{{ $id }}">
                    x
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="h-max max-h-[80dvh] overflow-y-auto p-4 sm:max-h-[72dvh]">
                @if (isset($content))
                    {{ $content }}
                @endif
            </div>
        </div>
    </div>
</div>
