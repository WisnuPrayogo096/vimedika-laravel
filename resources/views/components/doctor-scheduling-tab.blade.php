@props([
    'currentTab' => 'schedule',
    'title' => 'Penjadwalan Dokter',
])

@php
    $variants = [
        'active' =>
            'inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500',
        'inactive' =>
            'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
    ];
@endphp

<div>
    <div
        class="text-base font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px">
            @can('VIEW_DOCTOR_SCHEDULE')
                <li class="me-2">
                    <a href="/receptionists/doctor-scheduling"
                        class="{{ $currentTab == 'schedule' ? $variants['active'] : $variants['inactive'] }}">
                        Master Jadwal
                    </a>
                </li>
            @endcan
            @can('VIEW_CURRENT_DOCTOR_SCHEDULE')
                <li class="me-2">
                    <a href="/receptionists/doctor-scheduling/current"
                        class="{{ $currentTab == 'current_schedule' ? $variants['active'] : $variants['inactive'] }}">
                        Jadwal Hari Ini
                    </a>
                </li>
            @endcan
            @can('VIEW_DOCTOR_CHANGE_SCHEDULE')
                <li class="me-2">
                    <a href="/receptionists/doctor-scheduling/change-schedule"
                        class="{{ $currentTab == 'change_schedule' ? $variants['active'] : $variants['inactive'] }}">
                        Ganti Jadwal
                    </a>
                </li>
            @endcan
            @can('VIEW_DOCTOR_VACATION')
                <li class="me-2">
                    <a href="/receptionists/doctor-scheduling/vacation"
                        class="{{ $currentTab == 'vacation' ? $variants['active'] : $variants['inactive'] }}">
                        Cuti / Libur
                    </a>
                </li>
            @endcan
        </ul>
    </div>
    <div class="mt-6">
        <h3 class="text-xl font-semibold text-chinese-black dark:text-white mb-4 capitalize">
            {{ $title }}
        </h3>
        {{ $slot }}
    </div>
</div>
