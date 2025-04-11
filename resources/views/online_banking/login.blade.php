@extends('layouts.app')
@section('content')
<div class="min-h-screen flex justify-center items-center bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold">Login</h2>
        @if(session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif
        <form action="{{ route('online_banking.login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required class="w-full p-2 border rounded-md">
                @error('username')<div class="text-red-600">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" name="password" id="password" required class="w-full p-2 border rounded-md">
                @error('password')<div class="text-red-600">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md">Login</button>
        </form>
    </div>
</div>
@endsection