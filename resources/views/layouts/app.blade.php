<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title') | Vimedika App</title>
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    @notifyCss
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/search-menu.js') }}"></script>
    @stack('styles')
    <script src="{{ asset('js/menu-handler.js') }}"></script>
</head>

<body class="antialiased">
    <x-template>
        <div class="fixed z-[999999]">
            <x-notify::notify />
        </div>
        @yield('content')
    </x-template>
    @notifyJs
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    @stack('scripts')
</body>
