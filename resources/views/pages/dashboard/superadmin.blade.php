@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Hello World</h1>

    @if (isset($branchInfo))
        <div>
            <a href="#">Cabang: {{ $branchInfo['branch_name'] ?? 'N/A' }}</a>
            {{-- Atau data lain dari $branchInfo --}}
        </div>
    @endif
@endsection
