@extends('layouts.app')

@section('title', 'Investasi Dollar')

@section('content')
<main class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6">

<div class="mb-6 flex items-center justify-between">
    <!-- Judul dan deskripsi -->
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Investasi Dollar</h1>
      <p class="text-sm text-gray-500">Simulasi pembelian aset digital dollar.</p>
    </div>

    <x-breadcrumb />
  </div>

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

  <div class="flex flex-col gap-6">
      <div class="bg-white p-6 rounded-2xl shadow-lg h-fit flex flex-col gap-4">
  <h2 class="text-xl font-bold text-gray-800 mb-2">Saldo DompetKu</h2>
  
  <div class="grid md:grid-cols-2 gap-4">
    <!-- Saldo Rupiah -->
    <div class="bg-gradient-to-br from-green-100 to-green-200 p-4 rounded-xl shadow-inner">
      <p class="text-sm text-gray-700">Saldo Rupiah</p>
      <p class="text-2xl font-bold text-green-800 mt-1">
        Rp{{ number_format(auth()->user()->saldo ?? 0, 2, ',', '.') }}
      </p>
    </div>

    <!-- Saldo Dollar -->
    <div class="bg-gradient-to-br from-blue-100 to-blue-200 p-4 rounded-xl shadow-inner">
      <p class="text-sm text-gray-700">Saldo Dollar</p>
      <p class="text-2xl font-bold text-blue-800 mt-1">
        ${{ number_format(auth()->user()->saldo_dollar ?? 0, 2, ',', '.') }}
      </p>
    </div>
  </div>

  <p class="text-sm text-gray-500 mt-2">Saldo akan terpotong saat pembelian berhasil.</p>
</div>


  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ">
    <!-- Form Investasi -->
    <!-- Transaksi Investasi -->
<div class="bg-white p-6 rounded-2xl shadow-xl border">
  <h2 class="text-xl font-semibold mb-6 text-gray-800">Transaksi Investasi</h2>
  
  <div class="flex flex-col gap-4">
    <!-- Harga Dolar -->
    <div>
      <input id="rate-terakhir" type="hidden" value="{{ $latestRate }}">
      <div class="flex gap-2 justify-between">
      <span class="text-gray-500 text-sm">Harga Dolar Saat Ini</span>
       <div id="selisih-dollar" class="text-sm">(0.0000%)</div>
      </div>
      <div id="harga-dollar" class="text-3xl font-bold text-green-600">Rp 0</div>
    </div>

    <!-- Input Jumlah -->
    <div>
      <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah (USD)</label>
      <input type="number" id="jumlah-dollar" step="0.01" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" required>
    </div>
    <!-- Estimasi Hasil -->
<div class="bg-gray-100 p-4 rounded-lg shadow-inner text-sm text-gray-700">
  <p>Perkiraan Nilai dalam Rupiah:</p>
  <div id="hasil-idr" class="text-2xl font-semibold text-green-600">Rp 0</div>
</div>


    <!-- Tombol Aksi -->
    <div class="grid grid-cols-2 gap-4 mt-2">
      <form method="POST" action="{{ route('pembayaran.investasi.dollar.invest') }}">
        @csrf
        <input type="hidden" name="aksi" value="beli">
        <input type="hidden" name="rate" class="rate">
        <input type="hidden" name="jumlah" class="jumlah">
        <button type="submit" class="w-full text-center bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg shadow transition">Beli</button>
      </form>

      <form method="POST" action="{{ route('pembayaran.investasi.dollar.invest') }}">
        @csrf
        <input type="hidden" name="aksi" value="jual">
        <input type="hidden" name="rate" class="rate">
        <input type="hidden" name="jumlah" class="jumlah">
        <button type="submit" class="w-full text-center bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg shadow transition">Jual</button>
      </form>
    </div>
  </div>
</div>


  <!-- Grafik Harga Dolar -->
  <div class="bg-white p-4 rounded-lg shadow">
    <h2 class="text-lg font-semibold mb-4">Grafik Harga Dolar (USD to IDR)</h2>
    <canvas id="chartDollar" class="w-full h-64"></canvas>
  </div>

      

  <!-- Riwayat Transaksi -->
 
</div>
 <div class="bg-white p-4 rounded-lg shadow">
    <h2 class="text-lg font-semibold mb-4">Riwayat Investasi Dolar</h2>
    <table class="min-w-full text-sm">
      <thead>
        <tr>
          <th class="text-left px-2 py-1">Tanggal</th>
          <th class="text-left px-2 py-1">Aksi</th>
          <th class="text-left px-2 py-1">Jumlah (USD)</th>
          <th class="text-left px-2 py-1">Harga (IDR)</th>
          <th class="text-left px-2 py-1">Selisih</th>
          <th class="text-left px-2 py-1">Total (IDR)</th>
        </tr>
      </thead>
      <tbody>
        @foreach($riwayat as $item)
        <tr>
          <td class="px-2 py-1">{{ $item->created_at->format('d M Y H:i') }}</td>
          <td class="px-2 py-1">
                <span class="px-2 py-1 rounded-full text-xs font-semibold
                    @if($item->aksi == 'jual') bg-red-100 text-red-800
                    @elseif($item->aksi == 'beli') bg-green-100 text-green-800
                    @endif">
                    {{ ucfirst($item->aksi) }} 
                </span>
            </td>
          <td class="px-2 py-1">${{ $item->jumlah }}</td>
          <td class="px-2 py-1">Rp {{ number_format($item->rate, 2, ',', '.') }}</td>
          <td class="px-2 py-1">{{ number_format($item->selisih, 10, '.', '');  }}%</td>
          <td class="px-2 py-1">Rp {{ number_format($item->rate * $item->jumlah, 2, ',', '.') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
<main>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let hargaTerakhir = 0;
const rateTerakhirHidden = document.getElementById('rate-terakhir');
const hargaDiv = document.getElementById('harga-dollar');
const selisihDollarDiv = document.getElementById('selisih-dollar');
const hasilIdrDiv = document.getElementById('hasil-idr');
const jumlahDollarInput = document.getElementById('jumlah-dollar');
const jumlahInputHidden = document.getElementsByClassName('jumlah');
const rateInputHidden = document.getElementsByClassName('rate');

// Format helper
function formatIDR(val) {
  return 'Rp ' + val.toLocaleString('id-ID', {maximumFractionDigits: 2});
}

// Ambil data terbaru dari API
async function fetchDollarRates() {
  try {
    const response = await fetch('/pembayaran/investasi/dollar-rate');
    const data = await response.json();

    const values = data.map(item => item.value);
    hargaTerakhir = values[values.length - 1];

    if (hargaDiv) hargaDiv.innerText = formatIDR(hargaTerakhir);
    if (!isNaN(rateTerakhirHidden.value) && !isNaN(hargaTerakhir) && rateTerakhirHidden.value > 0) {
      const selisih = hargaTerakhir - rateTerakhirHidden.value;
      const persen = (selisih / rateTerakhirHidden.value) * 100;
      const simbol = selisih >= 0 ? '+' : '';
      const warna = selisih >= 0 ? 'text-green-600' : 'text-red-600';

      selisihDollarDiv.classList.add(warna)
      selisihDollarDiv.innerHTML = `
        (${simbol}${persen.toFixed(4)}%)
      `;
    }

    updateHasilIDR(); // update hasil juga

    updateChart(data); // optional: update chart
  } catch (error) {
    console.error('Error API:', error);
  }
}

// Hitung & tampilkan hasil IDR dari input user
function updateHasilIDR() {
  const jumlah = parseFloat(jumlahDollarInput.value) || 0;
  const hasil = jumlah * hargaTerakhir;
  hasilIdrDiv.innerText = formatIDR(hasil);
  Array.from(jumlahInputHidden).forEach((item, index) => {
    item.value = jumlah;
  });
  Array.from(rateInputHidden).forEach((item, index) => {
    item.value = hargaTerakhir.toFixed(2)
  });

}

// Event listener input jumlah
if (jumlahDollarInput) {
  jumlahDollarInput.addEventListener('input', updateHasilIDR);
}

// Update grafik jika diperlukan
function updateChart(data) {
  const labels = data.map(item => {
    const date = new Date(item.time);
    return date.getHours() + ":00";
  });
  const values = data.map(item => item.value);
  
  const ctx = document.getElementById('chartDollar').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'USD ke IDR (Per Jam)',
        data: values,
        borderColor: 'rgb(75, 192, 192)',
        fill: false,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      scales: {
        x: { title: { display: true, text: 'Jam' } },
        y: { title: { display: true, text: 'Harga (IDR)' } }
      }
    }
  });
}

// Pertama kali fetch saat halaman load
fetchDollarRates();

// Refresh tiap 1 menit (60.000 ms)
</script>

@endpush