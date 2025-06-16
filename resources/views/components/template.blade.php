<div>
    <x-navbar />
    <x-sidebar />
    <main id="main"
        class="py-4 px-4 lg:px-6 sm:ml-64 mt-[60px] min-h-[calc(100vh-60px-72px)] sm:min-h-[calc(100vh-60px-52px)] dark:text-white text-base">
        {{ $slot }}
    </main>
    <footer class="py-4 px-4 lg:px-6 sm:ml-64">
        <span class="text-gray-600 dark:text-gray-400 text-center block text-sm">
            © Copyright 2025 | Dikembangkan Oleh IT RSU UMM | Versi Aplikasi : {{ config('app.version') }}
        </span>
    </footer>
    <x-modal id="search-menu-modal" title="Cari Menu SIMRS">
        <x-slot name="content">
            <x-input id="search-menu" name="search_menu" placeholder="Pencarian menu ..." class="py-3" />
            <div id="existing-menu-list" class="text-gray-800 dark:text-gray-200 min-h-40 h-full">
            </div>
        </x-slot>
    </x-modal>
</div>
