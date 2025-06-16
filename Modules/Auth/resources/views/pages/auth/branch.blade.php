@extends('layouts.base')

@section('title', 'Branch')

@section('content')
    <div class="card">
        <h2>Pilih Cabang</h2>

        @if ($errorMessage)
            <p class="error-message">{{ $errorMessage }}</p>
        @endif

        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (count($branches) > 0)
            <form method="POST" action="{{ route('auth.select-branch') }}">
                @csrf
                <div>
                    <label for="branch">Cabang:</label>
                    <select id="branch" name="branch_id">
                        <option value="">-- Pilih Cabang --</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch['branch_id'] }}">{{ $branch['branch_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit">Lanjutkan</button>
            </form>
        @else
            <p>Tidak ada cabang yang tersedia.</p>
        @endif
    </div>
@endsection