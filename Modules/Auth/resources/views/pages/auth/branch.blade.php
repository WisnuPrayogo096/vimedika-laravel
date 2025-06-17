@extends('layouts.base')

@section('title', 'Branch')

@section('content')
    <div class="h-screen w-screen overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 h-full">
            <div class="w-full h-screen flex-col justify-center items-center hidden md:flex">
                <div class="w-full flex flex-col items-center justify-center space-y-10">
                    <div class="w-full flex items-center justify-center px-4 md:px-6 lg:px-10 xl:px-16">
                        <img src="{{ asset('images/branch-logo.png') }}" alt="Branch Logo"
                            class="object-contain w-full max-w-[300px] md:max-w-[400px] lg:max-w-[500px] xl:max-w-[554px] h-auto">
                    </div>
                </div>
            </div>
            <div
                class="bg-primary flex flex-col items-center justify-center px-6 py-10 md:px-12 lg:px-20 xl:px-32 min-h-screen">
                <div class="px-4 md:px-6 md:max-w-2xl lg:max-w-3xl xl:max-w-4xl">
                    <div class="relative w-full h-16 mb-8 flex md:hidden items-center justify-center">
                        <img src="{{ asset('images/logo-vimedika.png') }}" alt="Logo Vimedika"
                            class="object-contain h-full">
                    </div>

                    @if (!empty($branches) && count($branches) > 0)
                        <h2 class="text-center text-white font-bold text-xl md:text-2xl lg:text-3xl mb-3 leading-tight">
                            Pilih Cabang Apotek
                        </h2>
                        <p class="text-white text-center mb-8 font-medium text-sm md:text-base">
                            Pilih cabang apotek untuk melanjutkan
                        </p>

                        @foreach ($branches as $branch)
                            <div class="branch-item bg-white rounded-xl px-6 py-5 md:px-8 md:py-6 flex items-center space-x-4 shadow-md hover:shadow-lg outline-none hover:outline hover:outline-4 hover:outline-[#A0C878] focus:outline focus:outline-4 focus:outline-[#A0C878] transition-all duration-100 cursor-pointer mb-4"
                                data-branch-id="{{ $branch['branch_id'] }}">
                                <i class="fa-solid fa-store text-primary text-4xl md:text-5xl mr-2"></i>
                                <div class="flex flex-col px-1 md:px-2 lg:px-4 text-sm md:text-base">
                                    <h3 class="font-semibold text-gray-800 text-lg md:text-xl lg:text-2xl mb-1">
                                        {{ $branch['branch_name'] }}
                                    </h3>
                                    <p class="text-gray-800">SIA : {{ $branch['sia_name'] }} | SIPA :
                                        {{ $branch['sipa_name'] }}
                                    </p>
                                    <p class="text-gray-700"> {{ $branch['phone'] }} </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h2 class="text-center text-white font-semibold text-lg md:text-xl lg:text-2xl leading-tight">
                            <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                            Tidak ada cabang yang tersedia
                        </h2>
                        <div class="flex items-center justify-center mt-6">
                            <button onclick="window.location.href = '{{ route('auth.login') }}'"
                                class=" bg-white text-primary font-semibold py-2 px-6 rounded-lg hover:bg-gray-100 disabled:opacity-50">Login
                                kembali</button>
                        </div>
                    @endif

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

    <x-loading />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.branch-item').on('click', function() {
                const branchId = $(this).data('branch-id');
                const loading = document.getElementById('loading');
                loading.style.display = 'flex';
                console.log('Selected branch ID:', branchId);

                // Create and submit form
                // const form = document.createElement('form');
                // form.method = 'POST';
                // form.action = '{{ route('auth.select-branch') }}';

                // const csrfInput = document.createElement('input');
                // csrfInput.type = 'hidden';
                // csrfInput.name = '_token';
                // csrfInput.value = '{{ csrf_token() }}';

                // const branchInput = document.createElement('input');
                // branchInput.type = 'hidden';
                // branchInput.name = 'branch_id';
                // branchInput.value = branchId;

                // form.appendChild(csrfInput);
                // form.appendChild(branchInput);
                // document.body.appendChild(form);
                // form.submit();
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const loading = document.getElementById('loading');
            if (document.querySelector('.text-red-700')) {
                loading.style.display = 'none';
            }
        });
    </script>
@endsection
