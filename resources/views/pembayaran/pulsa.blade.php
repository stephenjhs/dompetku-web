@extends('layouts.app')

@section('title', 'Beli Pulsa')

@section('content')
<main class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6">

  <div class="mb-6 flex items-center justify-between">
    <!-- Judul dan deskripsi -->
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Pembelian Pulsa</h1>
      <p class="text-sm text-gray-500">Isi ulang pulsa ke nomor HP kamu kapan saja.</p>
    </div>

    <x-breadcrumb />
  </div>


  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Kolom Form Pembelian Pulsa -->
    <div class="bg-white p-6 rounded-xl shadow-sm">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Formulir Pulsa</h2>
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

      <form action="{{ route('pembayaran.pulsa.proses') }}" method="POST" id="formPulsa">
        @csrf

        <!-- Nomor HP -->
        <div class="mb-4">
          <label for="nomor_hp" class="block text-sm font-medium text-gray-700">Nomor HP</label>
          <input type="text" id="nomor_hp" name="nomor_hp" value="{{ auth()->user()->phone_number }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="08xxxxxxxxxx" required>
        </div>

        <!-- Provider -->
        <div class="mb-4">
          <label for="provider" class="block text-sm font-medium text-gray-700">Provider</label>
          <select id="provider" name="provider" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            <option value="">-- Pilih Provider --</option>
            <option value="Telkomsel">Telkomsel</option>
            <option value="XL">XL</option>
            <option value="Indosat">Indosat</option>
            <option value="Axis">Axis</option>
            <option value="Tri">Tri</option>
            <option value="Smartfren">Smartfren</option>
          </select>
        </div>

        <!-- Pilih Nominal Pulsa -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Nominal Pulsa</label>
          <input type="hidden" name="nominal" id="inputNominal">
          <input type="hidden" name="harga" id="inputHarga">
          <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            @foreach([5000,10000,15000,20000,25000,30000,40000,50000,60000,70000,75000,80000,90000,100000] as $value)
              <div onclick="pilihPulsa({{ $value }})" id="card-{{ $value }}"
                class="cursor-pointer border rounded-lg px-4 py-3 text-center hover:bg-indigo-50 transition shadow-sm">
                <p class="font-semibold text-gray-700">Rp {{ number_format($value, 0, ',', '.') }}</p>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Tombol Submit -->
        <div class="pt-6">
          <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition font-semibold">
            Beli Pulsa
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

    <!-- Kolom Informasi Tambahan (Saldo + Rincian Pembelian) -->
    <div class="bg-white p-6 rounded-xl shadow-md h-fit flex flex-col gap-6">
      <!-- Rincian Pembelian -->
      <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Rincian Pembelian</h2>
        <div id="infoHarga">
          <p class="text-gray-500">Silakan pilih nominal pulsa terlebih dahulu.</p>
        </div>
      </div>
    </div>
    </div>

    
  </div>
  <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Pembelian Pulsa</h2>
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
        <p class="text-sm text-gray-500">Belum ada riwayat topup.</p>
        @endif
    </div>

</main>

<script>
  const hargaPulsa = {
    5000: 6650,
    10000: 11550,
    15000: 16100,
    20000: 20950,
    25000: 25850,
    30000: 30950,
    40000: 40000,
    50000: 49800,
    60000: 59950,
    70000: 69700,
    75000: 74800,
    80000: 79800,
    90000: 89700,
    100000: 99200
  };

  let selectedCard = null;

  function pilihPulsa(nominal) {
    // Set value ke input hidden
    document.getElementById('inputNominal').value = nominal;

    // Highlight kartu
    if (selectedCard) {
      selectedCard.classList.remove('bg-indigo-100', 'border-indigo-600');
    }
    const currentCard = document.getElementById('card-' + nominal);
    currentCard.classList.add('bg-indigo-100', 'border-indigo-600');
    selectedCard = currentCard;

    // Update info harga
    const harga = hargaPulsa[nominal] ?? 0;

    document.getElementById('inputHarga').value = harga;

    document.getElementById('infoHarga').innerHTML = `
      <div class="space-y-2">
        <p class="text-gray-700">Pulsa yang dipilih:</p>
        <h3 class="text-xl font-bold text-indigo-600">Rp ${nominal.toLocaleString()}</h3>

        <div class="mt-4 border-t pt-4 space-y-1 text-sm text-gray-600">
          <div class="flex justify-between">
            <span>Harga Pulsa</span>
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
