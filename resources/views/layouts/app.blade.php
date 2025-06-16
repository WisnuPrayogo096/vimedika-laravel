<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title') | Vimedika App</title>
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    {{-- <link rel="icon" href="{{ asset('images/logo.png') }}"> --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @notifyCss
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <script src="{{ asset('js/search-menu.js') }}"></script> --}}
    @stack('styles')
    <script>
        if (
            localStorage.getItem('theme') === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            localStorage.setItem("theme", "dark");
            document.documentElement.classList.add('dark');
        } else {
            localStorage.setItem("theme", "light");
            document.documentElement.classList.remove('dark');
        }
    </script>
    {{-- <script src="{{asset('js/menu-handler.js')}}"></script> --}}
</head>

<body class="antialiased dark:bg-chinese-black">
    <x-template>
        <div class="fixed z-[999999]">
            @notify
        </div>
        @yield('content')
    </x-template>
    @notifyJs
    {{-- <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('/js/print.js') }}"></script> --}}
    @stack('scripts')
</body>
