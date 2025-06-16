@props([
    'menus' => [],
    'activeTab' => 0,
])

<div class="relative bg-white dark:bg-chinese-black rounded-lg shadow overflow-hidden">
    <button
        class="menu-nav-left absolute left-0 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-2 rounded-r-lg opacity-50 hover:opacity-90 hidden z-10">
        <i class="fa-solid fa-arrow-left"></i>
    </button>
    <button
        class="menu-nav-right absolute right-0 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-2 rounded-l-lg opacity-50 hover:opacity-90 hidden z-10">
        <i class="fa-solid fa-arrow-right"></i>
    </button>

    <div class="menu-container flex overflow-x-auto scrollbar-hidden border-b border-gray-200 dark:border-gray-700">
        @foreach ($menus as $key => $menu)
            <button
                class="menu-tab flex-shrink-0 px-6 py-3 text-sm font-medium text-gray-500 hover:text-blue-600 hover:border-blue-600 border-b-2 border-transparent {{ $key == $activeTab ? 'default-tab' : '' }}"
                data-target="{{ $menu['target'] }}">
                <i class="{{ $menu['icon'] }} mr-2"></i>
                <span>{{ $menu['name'] }}</span>
            </button>
        @endforeach
    </div>
</div>

<div class="mt-4">
    @foreach ($menus as $key => $menu)
        <div id="{{ $menu['target'] }}"
            class="tab-content {{ $key == $activeTab ? '' : 'hidden' }} bg-white dark:bg-chinese-black rounded-lg shadow p-6">
            {!! $menu['content'] !!}
        </div>
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.menu-tab');
        const tabContents = document.querySelectorAll('.tab-content');
        const menuContainer = document.querySelector('.menu-container');
        const navLeft = document.querySelector('.menu-nav-left');
        const navRight = document.querySelector('.menu-nav-right');

        function initializeTabs() {
            const currentTab = document.querySelector('.default-tab');
            if (currentTab) {
                currentTab.classList.add('active-tab', 'text-blue-600', 'border-blue-600');
                currentTab.classList.remove('text-gray-500', 'border-transparent');
                const targetId = currentTab.getAttribute('data-target');
                document.getElementById(targetId)?.classList.remove('hidden');
            }
        }

        initializeTabs();

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => {
                    t.classList.remove('active-tab', 'text-blue-600',
                        'border-blue-600');
                    t.classList.add('text-gray-500', 'border-transparent');
                });

                tab.classList.add('active-tab', 'text-blue-600', 'border-blue-600');
                tab.classList.remove('text-gray-500', 'border-transparent');

                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                const targetId = tab.getAttribute('data-target');
                document.getElementById(targetId)?.classList.remove('hidden');
            });
        });

        function updateNavButtons() {
            if (!menuContainer) return;
            const {
                scrollLeft,
                scrollWidth,
                clientWidth
            } = menuContainer;
            navLeft.classList.toggle('hidden', scrollLeft <= 0);
            navRight.classList.toggle('hidden', scrollLeft + clientWidth >= scrollWidth - 1);
        }

        if (menuContainer) {
            if (menuContainer.scrollWidth > menuContainer.clientWidth) {
                navRight.classList.remove('hidden');
            }

            menuContainer.addEventListener('scroll', updateNavButtons);

            navLeft.addEventListener('click', () => {
                menuContainer.scrollBy({
                    left: -150,
                    behavior: 'smooth'
                });
            });

            navRight.addEventListener('click', () => {
                menuContainer.scrollBy({
                    left: 150,
                    behavior: 'smooth'
                });
            });

            updateNavButtons();
        }
    });
</script>

<style>
    .scrollbar-hidden::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hidden {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
