@props([
    'currentTab' => 'role',
    'title' => 'Manajemen Role',
])

@php
    $variants = [
        'role' => [
            'role' =>
                'inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500',
            'access' =>
                'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
        ],
        'access' => [
            'role' =>
                'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
            'access' =>
                'inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500',
        ],
    ];
@endphp

<div>
    <div
        class="text-base font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px">
            <li class="me-2">
                <a href="/rbac/roles" class="{{ $variants[$currentTab]['role'] }}">
                    Role
                </a>
            </li>
            <li class="me-2">
                <a href="/rbac/accesses" class="{{ $variants[$currentTab]['access'] }}">
                    Akses
                </a>
            </li>
        </ul>
    </div>
    <div class="mt-6">
        <h3 class="text-xl font-semibold text-chinese-black dark:text-white mb-4 capitalize">
            {{ $title }}
        </h3>
        {{ $slot }}
    </div>
</div>
