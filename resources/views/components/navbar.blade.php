<nav class="fixed top-0 z-50 w-full bg-white border-b border-slate-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-slate-500 rounded-md sm:hidden hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fa-solid fa-bars"></i>
                </button>
                <a href="/" class="flex ms-2 md:me-24">
                    <img src="/images/logo.png" alt="Logo Vimedika" class="w-9 h-9 block">
                    <div class="ms-2 flex gap-2 items-end">
                        <span class="self-center font-bold text-primary sm:text-xl whitespace-nowrap hidden sm:block">
                            Vimedika
                        </span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-4 ms-3">
                <!-- Search Button -->
                <button id="search-button"
                    class="items-center px-4 py-2 min-w-[16em] w-full hidden md:flex gap-2 border pl-4 border-gray-200 font-medium justify-between text-sm text-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                    <div class="mr-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Cari menu</span>
                    </div>
                    <kbd class="px-2 text-xs font-semibold text-gray-800 bg-gray-100 rounded-lg">
                        Ctrl + M
                    </kbd>
                </button>

                <!-- Role Display -->
                <div class="flex items-center">
                    <div class="flex items-center md:order-2 space-x-1 md:space-x-0 rtl:space-x-reverse">
                        <div
                            class="items-center flex gap-2 border pl-4 border-gray-200 hover:text-green-600 font-medium justify-center text-sm text-gray-900 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="pr-4 py-2 flex gap-2 items-center whitespace-nowrap otoritas">
                                <i class="fa-solid fa-user-shield text-xs opacity-60"></i>
                                <span>Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="flex gap-4">
                    <button type="button"
                        class="flex text-sm bg-slate-900 rounded-full focus:ring-4 focus:ring-slate-300 hover:ring-2 transition-all"
                        aria-expanded="false" data-dropdown-toggle="dropdown-user">
                        <span class="sr-only">Open user menu</span>
                        <div
                            class="w-9 h-9 flex justify-center items-center rounded-full text-white font-semibold transition-colors">
                            <span class="block">U</span>
                        </div>
                    </button>
                </div>

                <!-- Dropdown Menu -->
                <div class="z-50 hidden my-4 text-base shadow-lg list-none bg-white divide-y divide-slate-100 rounded-lg border border-slate-200"
                    id="dropdown-user">
                    <div class="px-4 py-3" role="none">
                        <p class="text-sm text-slate-900 profile_name font-medium" role="none">
                            Loading...
                        </p>
                        <p class="text-sm text-slate-500 truncate email mt-1" role="none">
                            loading@example.com
                        </p>
                    </div>
                    <ul class="py-2" role="none">
                        <li>
                            <a href="/profile"
                                class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 transition-colors"
                                role="menuitem">
                                <i class="fa-solid fa-user mr-3 text-slate-400"></i>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="/settings"
                                class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 transition-colors"
                                role="menuitem">
                                <i class="fa-solid fa-cog mr-3 text-slate-400"></i>
                                Settings
                            </a>
                        </li>
                        <li class="border-t border-slate-100 mt-2 pt-2">
                            <form action="/auth/logout" method="POST" id="logout-form">
                                @csrf
                                <button role="menuitem" type="submit" id="btn-logout"
                                    class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fa-solid fa-sign-out-alt mr-3 text-red-400"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
