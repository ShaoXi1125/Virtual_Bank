@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-3xl font-bold mb-4">Dashboard</h2>
        <h3 class="text-xl font-semibold">Welcome, {{ $username }}</h3>

        <div class="mt-6">
            <h4 class="text-lg font-medium">Bank Accounts</h4>
            @if($cards->isEmpty())
                <p>No cards available.</p>
            @else
                <table class="w-full mt-4 border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">Card Number</th>
                            <th class="border p-2">Card Type</th>
                            <th class="border p-2">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cards as $card)
                        <tr>
                            <td class="border p-2">{{ $card->card_number }}</td>
                            <td class="border p-2">{{ $card->card_type }}</td>
                            <td class="border p-2">RM {{ $card->balance }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection