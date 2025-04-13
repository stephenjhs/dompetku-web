@extends('layouts.app')

@section('title', 'Riwayat Transaksi Pengguna')

@section('content')
<main class="p-4 md:p-6">
    <x-welcome-banner></x-welcome-banner>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 "> 
            <div class="bg-white rounded-xl overflow-hidden shadow lg:col-span-2">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">Transaksi Terbaru</h3>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse ($riwayat_transaksi as $transaksi)
                    <div class="p-4 flex items-center">
                        @php
                            $icon = 'fas fa-exchange-alt';
                            $bgColor = 'bg-gray-100';
                            $iconColor = 'text-gray-600';

                            if ($transaksi->kategori === 'topup') {
                                $icon = 'fas fa-arrow-down';
                                $bgColor = 'bg-blue-100';
                                $iconColor = 'text-blue-600';
                            } elseif ($transaksi->kategori === 'qr') {
                                $icon = 'fas fa-shopping-bag';
                                $bgColor = 'bg-red-100';
                                $iconColor = 'text-red-600';
                            } elseif ($transaksi->kategori === 'pulsa') {
                                $icon = 'fas fa-mobile-alt';
                                $bgColor = 'bg-purple-100';
                                $iconColor = 'text-purple-600';
                            }  elseif ($transaksi->kategori === 'token_listrik') {
                                $icon = 'fas fa-tachometer-alt';
                                $bgColor = 'bg-yellow-100';
                                $iconColor = 'text-yellow-600';
                            } elseif ($transaksi->kategori === 'transfer') {
                                $icon = 'fas fa-arrow-up';
                                $bgColor = 'bg-green-100';
                                $iconColor = 'text-green-600';
                            }
                        @endphp

                        <div class="{{ $bgColor }} w-10 h-10 rounded-full flex items-center justify-center mr-4">
                            <i class="{{ $icon }} {{ $iconColor }}"></i>
                        </div>

                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-800">
                                {{ $transaksi->deskripsi ?? ucwords(str_replace('_', ' ', $transaksi->kategori)) }}
                            </h4>
                            <p class="text-xs text-gray-500">
                                {{ $transaksi->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="{{ $transaksi->tipe === 'pemasukan' ? 'text-green-600' : 'text-red-600' }} font-medium">
                                {{ $transaksi->tipe === 'pemasukan' ? '+' : '-' }}Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ ucwords(str_replace('_', ' ', $transaksi->kategori)) }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-gray-500">Belum ada transaksi.</div>
                    @endforelse
                </div>
            </div>
            <div class="lg:col-span-1 space-y-6">
  <!-- Ringkasan Transaksi -->
  <div class="bg-white rounded-xl overflow-hidden card-shadow">
    <div class="p-4 border-b border-gray-100">
      <h3 class="font-semibold text-gray-800">Ringkasan Hari Ini</h3>
    </div>
    <div class="p-4 space-y-4">
      
      <!-- Hari Ini -->
      <div>
        <div class="flex justify-between text-sm text-gray-600 mb-1">
          <span class="text-sm">Pemasukan</span>
          <span class="text-green-600 font-medium">Rp {{ number_format($pemasukan_hari_ini, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-sm text-gray-600">
          <span>Pengeluaran</span>
          <span class="text-red-600 font-medium">Rp {{ number_format($pengeluaran_hari_ini, 0, ',', '.') }}</span>
        </div>
      </div>

     


    </div>
   
</div>
 <div class="bg-white rounded-xl overflow-hidden card-shadow">
    <div class="p-4 border-b border-gray-100">
      <h3 class="font-semibold text-gray-800">Ringkasan Bulan Ini</h3>
    </div>
    <div class="p-4 space-y-4">
      
      <!-- Hari Ini -->
      <div>
        <div class="flex justify-between text-sm text-gray-600 mb-1">
          <span class="text-sm">Pemasukan</span>
          <span class="text-green-600 font-medium">Rp {{ number_format($pemasukan_bulan_ini, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-sm text-gray-600">
          <span>Pengeluaran</span>
          <span class="text-red-600 font-medium">Rp {{ number_format($pengeluaran_bulan_ini, 0, ',', '.') }}</span>
        </div>
      </div>



    </div>
  </div>
  <div class="bg-white rounded-xl overflow-hidden card-shadow">
    <div class="p-4 border-b border-gray-100">
      <h3 class="font-semibold text-gray-800">Total Keseluruhan</h3>
    </div>
    <div class="p-4 space-y-4">
      


      <!-- Total -->
      <div class="pt-2">
        <div class="flex justify-between text-sm text-gray-600 mb-1">
          <span>Total Pemasukan</span>
          <span class="text-green-600 font-medium">Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-sm text-gray-600 mb-1">
          <span>Total Pengeluaran</span>
          <span class="text-red-600 font-medium">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-sm font-medium pt-2 border-t mt-2">
          <span>Saldo Akhir</span>
          <span>Rp {{ number_format($saldo_akhir) }}</span>
        </div>
      </div>

    </div>
  </div>

        </div>
</main>
@endsection
