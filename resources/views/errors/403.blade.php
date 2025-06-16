@extends('layouts.base')

@section('title', 'Forbidden')

@section('content')
    <section class="w-full h-dvh flex flex-col gap-2 items-center justify-center">
        <div class="mb-12">
            <img src="{{ asset('images/light-logo.png') }}" alt="Logo RS UMM" class="w-40 h-40 block dark:hidden">
            <img src="{{ asset('images/dark-logo.png') }}" alt="Logo RS UMM" class="w-40 h-40 hidden dark:block">
        </div>
        <h2 class="text-3xl font-semibold text-eerie-black dark:text-white">Ops, Akses Terlarang</h2>
        <p class="text-gray-600 dark:text-gray-200">Mohon maaf, anda tidak memiliki akses halaman ini.</p>
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
