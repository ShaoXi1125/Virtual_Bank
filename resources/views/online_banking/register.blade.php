@extends('layouts.app')
@section('content')
<div class="min-h-screen flex justify-center items-center bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold">Register</h2>
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif
        <form action="{{ route('online_banking.register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="client_id" class="block text-sm font-medium">Client ID</label>
                <input type="number" name="client_id" id="client_id" value="{{ old('client_id') }}" required class="w-full p-2 border rounded-md">
                @error('client_id')<div class="text-red-600">{{ $message }}</div>@enderror
            </div>
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
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white p-2 rounded-md">Register</button>
        </form>
    </div>
</div>
@endsection