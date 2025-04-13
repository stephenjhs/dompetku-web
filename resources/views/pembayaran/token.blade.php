@extends('layouts.app')

@section('title', 'Beli Token Listrik')

@section('content')
<main class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6">

  <div class="mb-6 flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Pembelian Token Listrik</h1>
      <p class="text-sm text-gray-500">Isi token listrik PLN ke nomor meteran kamu kapan saja.</p>
    </div>
    <x-breadcrumb />
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-xl shadow-sm">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Formulir Token Listrik</h2>

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

      <form action="{{ route('pembayaran.token.proses') }}" method="POST" id="formToken">
        @csrf

        <!-- Nomor Meteran -->
        <div class="mb-4">
          <label for="nomor_meter" class="block text-sm font-medium text-gray-700">Nomor Meteran</label>
          <input type="text" id="nomor_meter" name="nomor_meter" value="{{ old('nomor_meter') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nomor meteran PLN" required>
        </div>

        <!-- Nama Pelanggan -->
        <div class="mb-4">
          <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
          <input type="text" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan', auth()->user()->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <!-- Pilih Nominal Token -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Nominal Token</label>
          <input type="hidden" name="nominal" id="inputNominal">
          <input type="hidden" name="harga" id="inputHarga">
          <div class="grid grid-cols-3 gap-3">
            @foreach([20000, 50000, 100000, 200000, 500000] as $value)
              <div onclick="pilihToken({{ $value }})" id="card-{{ $value }}"
                class="cursor-pointer border rounded-lg px-4 py-3 text-center hover:bg-indigo-50 transition shadow-sm">
                <p class="font-semibold text-gray-700">Rp {{ number_format($value, 0, ',', '.') }}</p>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Tombol Submit -->
        <div class="pt-6">
          <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition font-semibold">
            Beli Token
          </button>
        </div>
      </form>
    </div>

    <div class="flex flex-col gap-6">
      <div class="bg-white p-6 rounded-xl shadow-md h-fit flex flex-col">
          <h2 class="text-lg font-semibold text-gray-800 mb-2">Saldo DompetKu</h2>
          <p class="text-2xl font-bold">
            Rp{{ number_format(auth()->user()->saldo ?? 0, 0, ',', '.') }}
          </p>
          <p class="text-sm text-gray-500 mt-1">Saldo akan terpotong saat pembelian berhasil.</p>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-md h-fit flex flex-col gap-6">
        <div>
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Rincian Pembelian</h2>
          <div id="infoHarga">
            <p class="text-gray-500">Silakan pilih nominal token terlebih dahulu.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white p-6 rounded-xl shadow">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Pembelian Token</h2>
    @if($riwayat->count())
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Tanggal</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Jumlah</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($riwayat as $item)
                <tr>
                    <td class="px-4 py-2">{{ $item->created_at->format('d M Y H:i') }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{!! $item->keterangan ?? '-' !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-sm text-gray-500">Belum ada riwayat pembelian token.</p>
    @endif
  </div>

</main>

<script>
  const hargaToken = {
    20000: 21500,
    50000: 51500,
    100000: 101500,
    200000: 201500,
    500000: 501500,
  };

  let selectedCard = null;

  function pilihToken(nominal) {
    document.getElementById('inputNominal').value = nominal;

    if (selectedCard) {
      selectedCard.classList.remove('bg-indigo-100', 'border-indigo-600');
    }
    const currentCard = document.getElementById('card-' + nominal);
    currentCard.classList.add('bg-indigo-100', 'border-indigo-600');
    selectedCard = currentCard;

    const harga = hargaToken[nominal] ?? 0;
    document.getElementById('inputHarga').value = harga;

    document.getElementById('infoHarga').innerHTML = `
      <div class="space-y-2">
        <p class="text-gray-700">Token yang dipilih:</p>
        <h3 class="text-xl font-bold text-indigo-600">Rp ${nominal.toLocaleString()}</h3>

        <div class="mt-4 border-t pt-4 space-y-1 text-sm text-gray-600">
          <div class="flex justify-between">
            <span>Harga Token</span>
            <span>Rp ${harga.toLocaleString()}</span>
          </div>
          <div class="flex justify-between font-semibold text-gray-800">
            <span>Total Bayar</span>
            <span>Rp ${harga.toLocaleString()}</span>
          </div>
        </div>
      </div>
    `;
  }
</script>
@endsection
