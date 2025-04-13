@extends('layouts.app')

@section('title', 'Kelola Pembayaran Digital Pengguna')

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

    <div class="overflow-x-auto p-6 bg-white shadow rounded-xl mb-6">
    <h1 class="text-xl font-bold mb-6 text-gray-800">Kelola Pembayaran Digital</h1>
        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="p-3 border">#</th>
                    <th class="p-3 border">Nama Pengguna</th>
                    <th class="p-3 border">Jenis Pembayaran</th>
                    <th class="p-3 border">Tujuan</th>
                    <th class="p-3 border">Jumlah</th>
                    <th class="p-3 border">Keterangan</th>
                    <th class="p-3 border">Tanggal</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($pembayaran as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border text-center">{{ $loop->iteration }}</td>
                        <td class="p-3 border">{{ $item->user->name }}</td>
                        <td class="p-3 border">
                            @if ($item->jenis === 'pulsa')
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Pulsa</span>
                            @elseif ($item->jenis === 'token_listrik')
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Token Listrik</span>
                            @else
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">QR</span>
                            @endif
                        </td>
                        <td class="p-3 border">{{ $item->tujuan }}</td>
                        <td class="p-3 border">Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td class="p-3 border">{!! $item->keterangan ?? '-' !!}</td>
                        <td class="p-3 border">{{ $item->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data pembayaran digital.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="overflow-x-auto p-6 bg-white shadow rounded-xl">
    <h1 class="text-xl font-bold mb-6 text-gray-800">Kelola Investasi Pengguna</h1>
        
        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="p-3 border">#</th>
                    <th class="p-3 border">Nama Pengguna</th>
                    <th class="p-3 border">Jenis</th>
                    <th class="p-3 border">Aksi</th>
                    <th class="p-3 border">Jumlah</th>
                    <th class="p-3 border">Rate</th>
                    <th class="p-3 border">Selisih</th>
                    <th class="p-3 border">Tanggal</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($investasi as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border text-center">{{ $loop->iteration }}</td>
                        <td class="p-3 border">{{ $item->user->name }}</td>
                        <td class="p-3 border">Dollar</td>
                        <td class="p-3 border">
                            @if ($item->aksi === 'beli')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Beli</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Jual</span>
                            @endif
                        </td>
                        <td class="p-3 border">${{ $item->jumlah }}</td>
                        <td class="p-3 border">Rp{{ number_format($item->rate, 2) }}</td>
                        <td class="p-3 border">
                            @if ($item->selisih > 0)
                                <span class="text-green-600">+{{ number_format($item->selisih, 10) }}%</span>
                            @elseif ($item->selisih < 0)
                                <span class="text-red-600">{{ number_format($item->selisih, 10) }}%</span>
                            @else
                                <span class="text-gray-500">0%</span>
                            @endif
                        </td>
                        <td class="p-3 border">{{ $item->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">Belum ada data investasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
