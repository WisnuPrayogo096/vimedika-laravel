@extends('layouts.base')

@section('title', 'Not Found')

@section('content')
    <section class="w-full h-dvh flex flex-col gap-2 items-center justify-center">
        <div class="mb-12">
            <img src="{{ asset('images/light-logo.png') }}" alt="Logo RS UMM" class="w-40 h-40 block dark:hidden">
            <img src="{{ asset('images/dark-logo.png') }}" alt="Logo RS UMM" class="w-40 h-40 hidden dark:block">
        </div>
        <h2 class="text-3xl font-semibold text-eerie-black dark:text-white">Halaman Tidak Ditemukan</h2>
        <p class="text-gray-600 dark:text-gray-200">Mohon maaf, halaman yang anda cari tidak ditemukan.</p>
        <div class="mt-8">
            <x-button id="btn-back">Kembali</x-button>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(function() {
            $('#btn-back').on('click', function() {
                window.history.back()
            })
        })
    </script>
@endpush
