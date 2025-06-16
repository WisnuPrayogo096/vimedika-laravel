@extends('layouts.base')

@section('title', 'Login')

@section('content')
    <div class="card">
        <h2>Login</h2>

        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('auth.login') }}">
            @csrf
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
@endsection
