@extends('layouts.app')

@section('title', 'Topup Saldo')

@section('content')
<main class="flex-1 p-4 md:p-6 space-y-6">
    <x-welcome-banner></x-welcome-banner>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
        <!-- Kolom Formulir -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Formulir Topup</h2>

            @if (session('success'))
                <div class="bg-green-100 text-green-600 p-4 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('topup.store') }}" method="POST">
                @csrf

                <!-- Nominal -->
                <div class="mb-4">
                    <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Nominal Topup (Rp)</label>
                    <input type="number" name="jumlah" id="jumlah" min="10000" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan jumlah topup">
                    @error('jumlah')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="mb-4">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan (opsional)</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Contoh: Transfer BRI a.n. Steven"></textarea>
                    @error('keterangan')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                        Ajukan Topup
                    </button>
                </div>
            </form>
        </div>

        <!-- Kolom Info Saldo -->
        
    </div>

    <!-- Kolom Riwayat Topup -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Topup</h2>
        @if($riwayat->count())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Tanggal</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Jumlah</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Status</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($riwayat as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->created_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($item->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($item->status == 'disetujui') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-sm text-gray-500">Belum ada riwayat topup.</p>
        @endif
    </div>
</main>
@endsection
