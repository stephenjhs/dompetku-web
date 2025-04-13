@php
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

    $lastActivity = DB::table('sessions')
        ->where('user_id', Auth::id())
        ->latest('last_activity')
        ->first();

    $lastActiveTime = $lastActivity 
        ? Carbon::createFromTimestamp($lastActivity->last_activity)->setTimezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB'
        : 'Tidak tersedia';
@endphp

@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<main class="flex-1 overflow-y-auto p-4 md:p-6">

    <!-- Welcome & Balance -->
    <div class="mb-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white card-shadow">
      <div class="flex flex-col md:flex-row md:items-center">
        <div>
          <p class="font-medium mb-1">Selamat datang kembali,</p>
          <h2 class="text-2xl font-bold mb-2">{{ auth()->user()->name }}</h2>
          <p class="text-blue-100">Terakhir aktif: {{ $lastActiveTime }}</p>
        </div>
      </div>
    </div>
     <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
      <!-- Card Topup -->
      <a href="{{ route('admin.topup.index') }}" class="bg-white rounded-xl p-5 flex flex-col card-shadow hover:bg-blue-50 transition-colors cursor-pointer">
        <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mb-3">
          <i class="fas fa-wallet text-blue-600"></i>
        </div>
        <h3 class="font-medium text-gray-800">Data Topup</h3>
      </a>
      
      <!-- Card Pembayaran Digital -->
      <a href="{{ route('admin.pembayaran.index') }}" class="bg-white rounded-xl p-5 flex flex-col card-shadow hover:bg-green-50 transition-colors cursor-pointer">
        <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mb-3">
          <i class="fas fa-shopping-cart text-green-600"></i>
        </div>
        <h3 class="font-medium text-gray-800">Data Pembayaran Digital</h3>
      </a>
      
      <!-- Card Transfer -->
      <a href="{{ route('admin.transfer.index') }}" class="bg-white rounded-xl p-5 flex flex-col card-shadow hover:bg-purple-50 transition-colors cursor-pointer">
        <div class="bg-purple-100 w-12 h-12 rounded-full flex items-center justify-center mb-3">
          <i class="fas fa-exchange-alt text-purple-600"></i>
        </div>
        <h3 class="font-medium text-gray-800">Data Transfer</h3>
      </a>
      
      <!-- Card Riwayat Transaksi -->
      <a href="{{ route('admin.users.index') }}" class="bg-white rounded-xl p-5 flex flex-col card-shadow hover:bg-purple-50 transition-colors cursor-pointer">
        <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mb-3">
          <i class="fas fa-user-friends text-blue-600"></i>
        </div>
        <h3 class="font-medium text-gray-800">Data Pengguna</h3>
      </a>
    </div>
</main>	
@endsection