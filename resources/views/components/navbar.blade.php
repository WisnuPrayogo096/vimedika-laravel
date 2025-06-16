<nav class="fixed top-0 z-50 w-full bg-white border-b border-slate-200 dark:bg-chinese-black dark:border-gray-800/70">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-slate-500 rounded-md sm:hidden hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:focus:ring-slate-600">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fa-solid fa-bars"></i>
                </button>
                <a href="/" class="flex ms-2 md:me-24">
                    <img src="{{ asset('images/light-logo.png') }}" alt="Logo RS UMM" class="w-9 h-9 block dark:hidden">
                    <img src="{{ asset('images/dark-logo.png') }}" alt="Logo RS UMM" class="w-9 h-9 hidden dark:block">
                    <div class="ms-2 flex gap-2 items-end">
                        <span
                            class="self-center font-semibold text-blue-800 sm:text-xl whitespace-nowrap dark:text-white hidden sm:block">
                            UMM Hospital
                        </span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-4 ms-3">
                <button id="search-button"
                    class="items-center px-4 py-2 min-w-[16em] w-full hidden md:flex gap-2 border pl-4 border-gray-200 dark:border-gray-700 font-medium justify-between text-sm text-gray-600 dark:text-gray-400 rounded-lg cursor-pointer dark:bg-eerie-black">
                    <div class="mr-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Cari menu
                    </div>
                    <kbd
                        class="px-2 text-xs font-semibold text-gray-800 bg-gray-100 rounded-lg dark:bg-gray-800 dark:text-gray-400">
                        Ctrl + M
                    </kbd>
                </button>
                <div class="flex items-center">
                    <div class="flex items-center md:order-2 space-x-1 md:space-x-0 rtl:space-x-reverse">
                        <div
                            class="items-center flex gap-2 border pl-4 border-gray-200 dark:hover:bg-slate-700 dark:border-gray-700 hover:text-blue-600 font-medium justify-center text-sm text-gray-900 dark:text-white  rounded-lg cursor-pointer hover:bg-gray-100 dark:bg-eerie-black">
                            <div id="spinner-menu" class="block">
                                <i
                                    class="fa-solid fa-circle-notch animate-spin text-blue-600 dark:text-blue-500 block"></i>
                                <span class="sr-only">Loading...</span>
                            </div>
                            <button type="button" data-dropdown-toggle="navbar-role" id="btn-dropdown-role"
                                data-default-role="{{ isset(auth()->user()->roles) ? auth()->user()->roles->first()->name : 'Tidak ada role' }}"
                                class="pr-4 py-2 flex gap-2 items-center whitespace-nowrap">
                                <i class="fa-solid fa-chevron-down text-sm"></i>
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base min-w-[12em] list-none dark:border-gray-700 bg-white divide-y divide-gray-100 dark:divide-gray-800 rounded-md shadow border border-gray-100 dark:bg-eerie-black"
                            id="navbar-role">
                            <div class="px-4 py-2" role="none">
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-left" role="none">
                                    Akses akun anda :
                                </p>
                            </div>
                            <ul class="py-2 font-medium" role="none">
                                @if (isset(auth()->user()->roles))
                                    @foreach (auth()->user()->roles as $role)
                                        <li>
                                            <button data-role-name="{{ $role->name }}"
                                                class="select-role block w-full text-left px-4 py-2 text-sm text-eerie-black hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                                role="menuitem">
                                                <div class="inline-flex items-center">
                                                    {{ $role->name }}
                                                </div>
                                            </button>
                                        </li>
                                    @endforeach
                                @else
                                    <li>
                                        <div
                                            class="select-role block w-full text-left px-4 py-2 text-sm text-eerie-black hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <div class="inline-flex items-center">
                                                Tidak ada role
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button type="button" id="darkModeButton"
                        class="me-2 w-9 h-9 rounded-lg aspect-square border border-slate-300 bg-white text-sm text-slate-500 hover:bg-slate-100 hover:text-blue-600 focus:z-10 focus:outline-none focus:ring-4 focus:ring-slate-100 dark:border-slate-700 dark:bg-eerie-black dark:text-slate-100 dark:hover:bg-slate-700 dark:hover:text-white dark:focus:ring-slate-800">
                        <span id="darkIcon">
                            <i class="fa-solid fa-cloud-moon hidden dark:block text-xs"></i>
                        </span>
                        <span id="lightIcon">
                            <i class="fa-solid fa-cloud-sun dark:hidden text-xs"></i>
                        </span>
                    </button>
                    <button type="button"
                        class="flex text-sm bg-slate-900 rounded-full focus:ring-4 focus:ring-slate-300 dark:focus:ring-slate-600"
                        aria-expanded="false" data-dropdown-toggle="dropdown-user">
                        <span class="sr-only">Open user menu</span>
                        <div
                            class="w-9 h-9 bg-blue-600 flex justify-center items-center rounded-full text-white font-semibold">
                            <span class="block">{{ auth()->user()->name[0] ?? 'S' }}</span>
                        </div>
                    </button>
                </div>
                <div class="z-50 hidden my-4 text-base shadow-md list-none bg-white divide-y divide-slate-100 rounded dark:bg-eerie-black dark:divide-slate-600 mr-6"
                    id="dropdown-user">
                    <div class="px-4 py-3" role="none">
                        <p class="text-sm text-slate-900 dark:text-white" role="none">
                            {{ auth()->user()->name ?? 'Halo adek' }}
                        </p>
                        <p class="text-sm font-medium text-slate-900 truncate dark:text-slate-300" role="none">
                            {{ auth()->user()->email ?? 'halo@admin.com' }}
                        </p>
                    </div>
                    <ul class="py-1" role="none">
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-eerie-black hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-600 dark:hover:text-white"
                                role="menuitem">Profile</a>
                        </li>
                        <li>
                            <form action="/auth/logout" method="POST" id="logout-form">
                                @csrf
                                <button role="menuitem" type="submit" id="btn-logout"
                                    class="block w-full text-left px-4 py-2 text-sm text-eerie-black hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-600 dark:hover:text-white">
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
