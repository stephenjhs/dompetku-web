@extends('layouts.app')

@section('title', 'Data Pengguna')

@section('content')
<main class="p-4 md:p-6">

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto p-6 bg-white shadow rounded-xl">
        <h1 class="text-xl font-bold mb-6 text-gray-800">Daftar Pengguna</h1>

        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="p-3 border">#</th>
                    <th class="p-3 border">Nama</th>
                    <th class="p-3 border">Username</th>
                    <th class="p-3 border">Email</th>
                    <th class="p-3 border">No. HP</th>
                    <th class="p-3 border">Saldo (Rp)</th>
                    <th class="p-3 border">Saldo Dollar ($)</th>
                    <th class="p-3 border">Role</th>
                    <th class="p-3 border">Bergabung</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border text-center">{{ $loop->iteration }}</td>
                        <td class="p-3 border">{{ $user->name }}</td>
                        <td class="p-3 border">{{ $user->username }}</td>
                        <td class="p-3 border">{{ $user->email }}</td>
                        <td class="p-3 border">{{ $user->phone_number ?? '-' }}</td>
                        <td class="p-3 border">Rp{{ number_format($user->saldo, 0, ',', '.') }}</td>
                        <td class="p-3 border">${{ number_format($user->saldo_dollar, 2, '.', ',') }}</td>
                        <td class="p-3 border">
                            <span class="inline-block px-2 py-1 text-xs rounded 
                                {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="p-3 border">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-gray-500">Belum ada pengguna terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
