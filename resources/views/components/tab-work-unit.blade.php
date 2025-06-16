@props([
    'currentTab' => 'field',
    'title' => 'Bidang Unit Kerja',
])

@php
    $variants = [
        'field' => [
            'filed' =>
                'inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500',
            'work_unit' =>
                'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
            'subunit' =>
                'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
        ],
        'work_unit' => [
            'filed' =>
                'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
            'work_unit' =>
                'inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500',
            'subunit' =>
                'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
        ],
        'subunit' => [
            'filed' =>
                'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
            'work_unit' =>
                'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
            'subunit' =>
                'inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500',
        ],
    ];
@endphp

<div>
    <div
        class="text-base font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px">
            <li class="me-2">
                <a href="/master-employee-and-organization/fields" class="{{ $variants[$currentTab]['filed'] }}">
                    Bidang Unit
                </a>
            </li>
            <li class="me-2">
                <a href="/master-employee-and-organization/work-units" class="{{ $variants[$currentTab]['work_unit'] }}">
                    Unit Kerja
                </a>
            </li>
            <li class="me-2">
                <a href="/master-employee-and-organization/subunits" class="{{ $variants[$currentTab]['subunit'] }}">
                    Subunit Kerja
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
