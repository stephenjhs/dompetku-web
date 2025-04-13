@extends('layouts.app')

@section('title', 'Kelola Topup Pengguna')

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
        <div class="flex justify-between items-center mb-6 ">
              <h1 class="text-xl font-bold text-gray-800">Kelola Permintaan Topup</h1>
                <span class="bg-indigo-600 py-2 px-3 rounded text-xs text-white font-semibold">Total Nominal: Rp{{ number_format($totalTopup, 0, ',', '.') }}</span>
        </div>

        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="p-3 border">#</th>
                    <th class="p-3 border">Nama Pengguna</th>
                    <th class="p-3 border">Nominal</th>
                    <th class="p-3 border">Keterangan</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Tanggal</th>
                    <th class="p-3 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($topups as $topup)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border text-center">{{ $loop->iteration }}</td>
                        <td class="p-3 border">{{ $topup->user->name }}</td>
                        <td class="p-3 border">Rp{{ number_format($topup->jumlah, 0, ',', '.') }}</td>
                        <td class="p-3 border">{{ $topup->keterangan ?? '-' }}</td>
                        <td class="p-3 border">
                            @if ($topup->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span>
                            @elseif ($topup->status === 'disetujui')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Disetujui</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Ditolak</span>
                            @endif
                        </td>
                        <td class="p-3 border">{{ $topup->created_at->format('d M Y H:i') }}</td>
                        <td class="p-3 border text-center">
                            @if ($topup->status === 'pending')
                                <div class="flex gap-2 justify-center">
                                    <form action="{{ route('admin.topup.verifikasi', $topup->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 text-xs rounded hover:bg-green-700">
                                            Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.topup.tolak', $topup->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 text-xs rounded hover:bg-red-700">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Belum ada permintaan topup.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
