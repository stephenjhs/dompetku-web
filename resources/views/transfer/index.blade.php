@extends('layouts.app')

@section('title', 'Transfer Saldo')

@section('content')
<main class="flex-1 p-4 md:p-6 space-y-6">
    <x-welcome-banner></x-welcome-banner>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
        <!-- Kolom Form Transfer -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Formulir Transfer</h2>

            @if (session('success'))
                <div class="bg-green-100 text-green-600 p-4 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-600 p-4 rounded mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('transfer.store') }}" method="POST">
                @csrf

                <!-- Tujuan -->
                <div class="mb-4">
                    <label for="ke_tipe" class="block text-sm font-medium text-gray-700 mb-1">Tipe Tujuan</label>
                    <select name="ke_tipe" id="ke_tipe" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="dompetku">DompetKu</option>
                        <option value="dana">DANA</option>
                        <option value="ovo">OVO</option>
                        <option value="gopay">GoPay</option>
                        <option value="bri">BRI</option>
                        <option value="bni">BNI</option>
                        <option value="mandiri">Mandiri</option>
                    </select>
                </div>

                <!-- Nomor Tujuan -->
                <div class="mb-4">
                    <label for="ke_nomor" class="block text-sm font-medium text-gray-700 mb-1">Nomor Tujuan</label>
                    <input type="text" name="ke_nomor" id="ke_nomor" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2"
                        placeholder="Masukkan nomor tujuan">
                </div>

                <!-- Jumlah -->
                <div class="mb-4">
                    <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Transfer (Rp)</label>
                    <input type="number" name="jumlah" id="jumlah" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2"
                        placeholder="Masukkan jumlah transfer">
                </div>

                <!-- Tombol -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Proses Transfer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Riwayat Transfer -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Transfer</h2>
        @if($riwayat->count())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-700">Tanggal</th>
                        <th class="px-4 py-2 text-left text-gray-700">Tujuan</th>
                        <th class="px-4 py-2 text-left text-gray-700">Jumlah</th>
                        <th class="px-4 py-2 text-left text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($riwayat as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->created_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-2">
                            @if($item->ke_tipe === 'dompetku')
                                Dompetku - {{ $item->ke_nama }} - {{ $item->ke_nomor }}
                            @else
                                {{ ucfirst($item->ke_tipe) }} - {{ $item->ke_nomor }}
                            @endif
                        </td>
                        <td class="px-4 py-2">Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($item->status == 'berhasil') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-sm text-gray-500">Belum ada riwayat transfer.</p>
        @endif
    </div>
</main>
@endsection
