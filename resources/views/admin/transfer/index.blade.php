@extends('layouts.app')

@section('title', 'Kelola Transfer Pengguna')

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
        <h1 class="text-xl font-bold mb-6 text-gray-800">Kelola Data Transfer</h1>

        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="p-3 border">#</th>
                    <th class="p-3 border">Dari Pengguna</th>
                    <th class="p-3 border">Ke Tujuan</th>
                    <th class="p-3 border">Tipe</th>
                    <th class="p-3 border">Nominal</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Tanggal</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($transfers as $transfer)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border text-center">{{ $loop->iteration }}</td>
                        <td class="p-3 border">{{ $transfer->dariUser->name }}</td>
                        <td class="p-3 border">{{ $transfer->ke_nama }} <br> <span class="text-sm text-gray-500">{{ $transfer->ke_nomor }}</span></td>
                        <td class="p-3 border capitalize">{{ $transfer->ke_tipe }}</td>
                        <td class="p-3 border">Rp{{ number_format($transfer->jumlah, 0, ',', '.') }}</td>
                        <td class="p-3 border">
                            @if ($transfer->status === 'berhasil')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Berhasil</span>
                            @elseif ($transfer->status === 'gagal')
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Gagal</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span>
                            @endif
                        </td>
                        <td class="p-3 border">{{ $transfer->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data transfer.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
