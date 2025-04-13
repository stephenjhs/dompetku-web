@extends('layouts.app')

@section('title', auth()->user()->username . ' - Profil Pengguna')

@section('content')
<main class="flex-1 p-4 md:p-6 space-y-6">
    <x-welcome-banner></x-welcome-banner>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <!-- Card Profil Utama -->
    <div class="bg-white rounded-xl card-shadow p-6 flex flex-col justify-center items-center text-center space-y-4">
      <div class="bg-blue-100 text-blue-600 w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold">
        @php
          $parts = explode(' ', trim(Auth::user()->name));
          $inisial = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
        @endphp
        {{ $inisial }}
      </div>
      <div>
        <h2 class="text-lg font-semibold text-gray-800">{{ Auth::user()->name }}</h2>
        <p class="text-sm text-gray-500">{{ "@" . Auth::user()->username }}</p>
        <span class="inline-block mt-2 px-3 py-1 rounded-full bg-gray-100 text-sm text-gray-600">
          {{ ucfirst(Auth::user()->role) }}
        </span>
      </div>
    </div>

    <!-- Info Detail -->
    <div class="md:col-span-2 bg-white rounded-xl card-shadow p-6 space-y-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Pengguna</h3>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <p class="text-sm text-gray-500">Email</p>
          <p class="font-medium text-gray-800">{{ Auth::user()->email }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Nomor Telepon</p>
          <p class="font-medium text-gray-800">
            {{ Auth::user()->phone_number ?? '-' }}
          </p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Tanggal Daftar</p>
          <p class="font-medium text-gray-800">
            {{ Auth::user()->created_at->format('d M Y') }}
          </p>
        </div>
      </div>

      <h3 class="text-lg font-semibold text-gray-800 mt-8 border-b pb-2">Informasi Keuangan</h3>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-green-50 rounded-lg p-4">
          <p class="text-sm text-gray-500">Saldo Rupiah</p>
          <p class="text-lg font-semibold text-green-600">
            Rp {{ number_format(Auth::user()->saldo, 2, ',', '.') }}
          </p>
        </div>
        <div class="bg-blue-50 rounded-lg p-4">
          <p class="text-sm text-gray-500">Saldo Dollar</p>
          <p class="text-lg font-semibold text-blue-600">
            ${{ number_format(Auth::user()->saldo_dollar, 2, ',', '.') }}
          </p>
        </div>
      </div>
    </div>

  </div>
</main>
@endsection
