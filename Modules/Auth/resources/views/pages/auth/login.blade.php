@extends('layouts.base')

@section('title', 'Login')

@section('content')
    <div class="h-screen w-screen overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 h-full">
            <div class="w-full h-screen flex-col justify-center items-center hidden md:flex">
                <div class="w-full flex flex-col items-center justify-center space-y-10">
                    <h2 class="text-primary text-center space-y-2 py-10 font-bold text-xl md:text-3xl xl:text-4xl">
                        <span class="block">Selamat Datang di Vimedika!</span>
                    </h2>
                    <div class="w-full flex items-center justify-center">
                        <img src="{{ asset('images/login-logo.png') }}" alt="Login Logo"
                            class="object-contain w-[554px] h-[393px]">
                    </div>
                </div>
            </div>
            <div class="bg-primary flex flex-col items-center justify-center px-6 relative">
                <div class="max-w-[24rem] w-full">
                    <div class="relative w-full h-16 mb-8 md:hidden flex items-center justify-center">
                        <img src="{{ asset('images/logo-vimedika.png') }}" alt="Logo Vimedika"
                            class="object-contain w-full h-full">
                    </div>
                    <h2 class="text-center leading-relaxed mb-3 text-2xl md:text-3xl text-white font-bold">
                        Sign In
                    </h2>
                    <p class="text-white text-center mb-8 font-medium">
                        Masuk ke akun anda untuk melanjutkan
                    </p>
                    <form id="loginForm" action="{{ route('auth.login') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="space-y-6">
                            <x-input-label type="text" label="Username" id="username" name="username" required />
                            <x-input-label type="password" label="Password" id="password" name="password" required />
                        </div>
                        <div class="flex w-full items-center justify-center mt-10">
                            <button type="submit"
                                class="w-full bg-white text-primary font-semibold py-2 px-4 rounded-lg hover:bg-gray-100 disabled:opacity-50">Login</button>
                        </div>
                    </form>
                    @if ($errors->any())
                        <div class="mt-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <ul class="list-disc list-inside space-y-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-loading text="Signing into your account" />

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            // nonaktif tombol submit
            const submitButton = this.querySelector('button[type="submit"]');
            const loading = document.getElementById('loading');

            // tampilkan loading dan nonaktif tombol submit
            loading.style.display = 'flex';
            submitButton.disabled = true;
        });

        // handle respon form submit
        document.addEventListener('DOMContentLoaded', function() {
            const loading = document.getElementById('loading');
            const submitButton = document.querySelector('button[type="submit"]');

            // jika terjadi error, hide loading dan enable button submit
            if (document.querySelector('.text-red-700')) {
                loading.style.display = 'none';
                submitButton.disabled = false;
            }
        });
    </script>
@endsection
