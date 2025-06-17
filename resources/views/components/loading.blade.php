@props(['text' => 'Loading'])

<style>
    .animate-ellipsis::after {
        content: '';
        animation: ellipsis 1.5s infinite;
    }

    @keyframes ellipsis {
        0% {
            content: '';
        }

        25% {
            content: '.';
        }

        50% {
            content: '..';
        }

        75% {
            content: '...';
        }

        100% {
            content: '';
        }
    }
</style>

<div id="loading" class="fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center z-50"
    style="display: none;">
    <div class="flex flex-col items-center space-y-4">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-white"></div>
        <span class="text-white text-xl font-semibold animate-ellipsis">{{ $text }} </span>
    </div>
</div>
