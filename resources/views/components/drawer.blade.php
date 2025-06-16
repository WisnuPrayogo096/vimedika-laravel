@props(['title'])

<div id="drawer"
    class="fixed border-l border-l-gray-200 dark:border-l-gray-800/70 top-[63px] h-[calc(100vh-62px)] right-0 z-[99999] p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-eerie-black"
    tabindex="-1">
    <h5 id="drawer-right-label"
        class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
        {{ $title }}
    </h5>
    <button type="button" data-drawer-hide="drawer" aria-controls="drawer"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-700 dark:hover:text-white">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close menu</span>
    </button>
    <div>
        {{ $slot }}
    </div>
</div>
