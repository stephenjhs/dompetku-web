@extends('layouts.app')

@section('title', 'Pembayaran Digital')

@section('content')
<main class="flex-1 overflow-y-auto p-4 md:p-6">

    <x-welcome-banner></x-welcome-banner>

    <!-- Menu Pembayaran -->
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Pilih Jenis Pembayaran</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        <!-- Pulsa -->
        <a href="{{ route('pembayaran.pulsa') }}" class="bg-white rounded-xl p-5 flex flex-col card-shadow hover:bg-blue-50 transition-colors">
            <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mb-3">
                <i class="fas fa-mobile-alt text-blue-600"></i>
            </div>
            <h3 class="font-medium text-gray-800">Beli Pulsa</h3>
        </a>

        <!-- Token Listrik -->
        <a href="{{ route('pembayaran.token') }}" class="bg-white rounded-xl p-5 flex flex-col card-shadow hover:bg-yellow-50 transition-colors">
            <div class="bg-yellow-100 w-12 h-12 rounded-full flex items-center justify-center mb-3">
                <i class="fas fa-bolt text-yellow-600"></i>
            </div>
            <h3 class="font-medium text-gray-800">Token Listrik</h3>
        </a>

        <!-- Scan QR -->
        <a href="{{ route('pembayaran.qr') }}" class="bg-white rounded-xl p-5 flex flex-col card-shadow hover:bg-purple-50 transition-colors">
            <div class="bg-purple-100 w-12 h-12 rounded-full flex items-center justify-center mb-3">
                <i class="fas fa-qrcode text-purple-600"></i>
            </div>
            <h3 class="font-medium text-gray-800">Pembayaran QR</h3>
        </a>

        <!-- Invest Dollar -->
        <a href="{{ route('pembayaran.investasi.dollar') }}" class="bg-white rounded-xl p-5 flex flex-col card-shadow hover:bg-green-50 transition-colors">
            <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mb-3">
                <i class="fas fa-dollar-sign text-green-600"></i>
            </div>
            <h3 class="font-medium text-gray-800">Invest Dollar</h3>
        </a>

    </div>

</main>
@endsection
