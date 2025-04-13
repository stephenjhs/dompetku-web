@extends('layouts.app')

@section('title', 'Pembayaran QRIS')

@section('content')
<!-- Konten Utama -->
<main class="flex-1 overflow-y-auto p-4 md:p-6 lg:space-y-6">

  <!-- Header -->
  <div class="mb-6 flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Pembayaran QRIS</h1>
      <p class="text-sm text-gray-500">Scan dan bayar QRIS merchant dengan mudah.</p>
    </div>
    <x-breadcrumb />
  </div>

  <!-- 2 Kolom Utama -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Kolom 1: Scanner -->
    <div class="bg-white p-6 rounded-xl shadow-sm">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Scan QR Code</h2>

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

      <div id="reader" class="w-full mb-4 rounded overflow-hidden"></div>
      <div id="reader-temp" class="hidden"></div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Unggah Gambar QR</label>
        <input type="file" id="qr-upload" accept="image/*" onchange="handleQRImage(this)" class="mt-2 block w-full text-sm">
      </div>
    </div>

    <!-- Kolom 2: Saldo + Info QRIS -->
    <div class="space-y-6" id="qris-wrapper">

      <!-- Saldo Pengguna -->
      <div class="bg-white border-l-4 border-indigo-500 rounded-xl p-4 shadow">
        <div class="text-sm text-gray-500">Saldo DompetKu</div>
        <div class="text-2xl font-bold text-gray-800">Rp{{ number_format(auth()->user()->saldo, 2, ',', '.') }}</div>
      </div>

      <!-- Container Info QR -->
      <div id="qris-info"></div>
    </div>
  </div>

  <!-- Riwayat Pembayaran -->
  <div class="bg-white p-6 rounded-xl shadow-sm h-fit">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Pembayaran QR</h2>
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
    <p class="text-sm text-gray-500">Belum ada transaksi QRIS.</p>
    @endif
  </div>
</main>

@endsection

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let currentQrScanner = null;

function parseTLV(data) {
  const result = {};
  let i = 0;
  while (i < data.length) {
    const tag = data.substr(i, 2);
    const len = parseInt(data.substr(i + 2, 2), 10);
    const val = data.substr(i + 4, len);
    result[tag] = val;
    i += 4 + len;
  }
  return result;
}

function parseQRIS(text) {
  const raw = parseTLV(text);
  const parsed = {};

  if (raw['59']) parsed.merchant = raw['59'];
  if (raw['60']) parsed.lokasi = raw['60'];
  if (raw['54']) parsed.nominal = parseFloat(raw['54']);

  const domainMerchantRaw = raw['26'] || raw['51'];
  if (domainMerchantRaw) {
    const merchantTLV = parseTLV(domainMerchantRaw);
    if (merchantTLV['00']) {
      const domain = merchantTLV['00'];
      const parts = domain.replace('.WWW', '').split('.');
      parsed.bank = parts[parts.length - 1];
    }
  }

  return parsed;
}

function tampilkanQRIS(data) {
  const container = document.getElementById("qris-info");
  if (!container) return;

  container.innerHTML = `
    <form action="{{ route('pembayaran.qr.proses') }}" method="POST" class="rounded-xl shadow border border-indigo-300 overflow-hidden">
      @csrf

      <!-- Header -->
      <div class="bg-indigo-600 text-white px-6 py-6">
        <h2 class="text-lg font-semibold">Informasi QRIS</h2>
      </div>

      <!-- Body -->
      <div class="bg-white px-6 py-4 space-y-6">

          <div class="text-xl font-bold text-gray-800">${data.merchant || '-'}</div>
          <div class="text-sm text-gray-600">${data.bank || '-'} | ${data.lokasi || '-'}</div>
          ${
            data.nominal !== undefined
              ? `<div class="text-lg text-green-700 font-semibold">Rp ${data.nominal.toLocaleString()}</div>
                 <input type="hidden" name="nominal" value="${data.nominal}">`
              : `<input type="number" name="nominal" placeholder="Masukkan nominal" class="mt-2 w-full border rounded p-2" required>`
          }

        <input type="hidden" name="merchant" value="${data.merchant || ''}">
        <input type="hidden" name="bank" value="${data.bank || ''}">
        <input type="hidden" name="lokasi" value="${data.lokasi || ''}">

        <!-- Tombol Aksi -->
        <div class="flex flex-col sm:flex-row justify-between gap-3 pt-2">
          <button type="submit" class="flex-1 px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700 transition">
            Proses Pembayaran
          </button>
          <button type="button" onclick="resetScan()" class="flex-1 px-4 py-2 rounded border border-indigo-500 text-indigo-600 hover:bg-indigo-50 transition">
            Ulangi Scan
          </button>
        </div>
      </div>
    </form>
  `;
}


function resetScan() {
  const container = document.getElementById("qris-info");
  if (container) container.innerHTML = '';

  if (currentQrScanner) {
    Html5Qrcode.getCameras().then(devices => {
      if (devices.length) {
        const backCam = devices.find(d => d.label.toLowerCase().includes("back") || d.label.toLowerCase().includes("environment"));
        const camId = backCam ? backCam.id : devices[0].id;

        currentQrScanner.start(
          camId,
          { fps: 10, qrbox: 250 },
          qrText => {
            currentQrScanner.stop();
            const data = parseQRIS(qrText);
            tampilkanQRIS(data);
          }
        );
      }
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  currentQrScanner = new Html5Qrcode("reader");

  Html5Qrcode.getCameras().then(devices => {
    if (devices.length) {
      const backCam = devices.find(d => d.label.toLowerCase().includes("back") || d.label.toLowerCase().includes("environment"));
      const camId = backCam ? backCam.id : devices[0].id;

      currentQrScanner.start(
        camId,
        { fps: 10, qrbox: 250 },
        qrText => {
          currentQrScanner.stop();
          const data = parseQRIS(qrText);
          tampilkanQRIS(data);
        }
      );
    }
  }).catch(err => {
    alert("Gagal mengakses kamera: " + err);
  });
});

function handleQRImage(input) {
  const file = input.files[0];
  if (!file) return;

  const qr = new Html5Qrcode("reader-temp");
  qr.scanFile(file, true)
    .then(decodedText => {
      const data = parseQRIS(decodedText);
      tampilkanQRIS(data);
    })
    .catch(err => {
      alert("Gagal membaca QR Code: " + err);
    });
}
</script>
