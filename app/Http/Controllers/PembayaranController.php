<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran;
use App\Models\Investasi;
use App\Models\RiwayatTransaksi;
use Zxing\QrReader;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class PembayaranController extends Controller
{
    // Tampilkan halaman utama pembayaran digital
    public function index()
    {
        return view('pembayaran.index');
    }

    // Form dan proses pembelian pulsa
    public function beliPulsa(Request $request)
    {
        $riwayat = Pembayaran::where('user_id', Auth::id())
            ->where('jenis', 'pulsa')
            ->latest()
            ->get();
        return view('pembayaran.pulsa', compact('riwayat'));
    }

    public function prosesPulsa(Request $request)
    {
        $request->validate([
            'nomor_hp' => 'required|string',
            'provider' => 'required|string',
        ]);

        $user = Auth::user();

        // Cek apakah saldo cukup
        if ($user->saldo < $request->harga) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk pembelian ini.');
        }

        // Potong saldo
        $user->saldo -= $request->harga;
        $user->save();

        $keterangan = "Nomor: {$request->nomor_hp}\n" .
              "Provider: {$request->provider}\n" .
              "Nominal: Rp" . number_format($request->nominal, 0, ',', '.') . ",00\n" .
              "Harga Pembelian: Rp" . number_format($request->harga, 0, ',', '.') . ",00";
        $keterangan = nl2br($keterangan);

        Pembayaran::create([
            'user_id' => Auth::id(),
            'jenis' => 'pulsa',
            'tujuan' => $request->nomor_hp,
            'jumlah' => $request->harga,
            'keterangan' => $keterangan,
            'status' => 'berhasil',
        ]);

        RiwayatTransaksi::create([
        'user_id' => Auth::id(),
        'tipe' => 'pengeluaran',
        'kategori' => 'pulsa',
        'jumlah' => $request->harga,
        'deskripsi' => 'Isi pulsa sebesar Rp' . $request->nominal . ' dengan harga Rp' . number_format($request->harga, 2, ',', '.'),
    ]);

        return redirect()->route('pembayaran.pulsa')->with('success', 'Pembelian pulsa berhasil dilakukan!');
    }


    // Form dan proses pembelian token listrik
    public function beliToken(Request $request)
    {
        $riwayat = Pembayaran::where('user_id', Auth::id())
            ->where('jenis', 'token_listrik')
            ->latest()
            ->get();
        return view('pembayaran.token', compact('riwayat'));
    }

    public function prosesToken(Request $request) {
         $request->validate([
            'nomor_meter' => 'required|string',
            'nama_pelanggan' => 'required|string',
            'nominal' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        $user = Auth::user();

        // Cek saldo cukup
        if ($user->saldo < $request->harga) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk pembelian token listrik.');
        }

        // Potong saldo
        $user->saldo -= $request->harga;
        $user->save();

        // Buat keterangan
        $keterangan = "Nomor Meter: {$request->nomor_meter}\n" .
                      "Nama Pelanggan: {$request->nama_pelanggan}\n" .
                      "Nominal Token: Rp" . number_format($request->nominal, 0, ',', '.') . ",00\n" .
                      "Harga Pembelian: Rp" . number_format($request->harga, 0, ',', '.') . ",00";
        $keterangan = nl2br($keterangan);

        // Simpan ke tabel pembayaran
        Pembayaran::create([
            'user_id' => Auth::id(),
            'jenis' => 'token_listrik',
            'tujuan' => $request->nomor_meter,
            'jumlah' => $request->harga,
            'keterangan' => $keterangan,
        ]);

        RiwayatTransaksi::create([
        'user_id' => Auth::id(),
        'tipe' => 'pengeluaran',
        'kategori' => 'token_listrik',
        'jumlah' => $request->harga,
        'deskripsi' => 'Isi token listrik sebesar Rp' . $request->nominal . ' dengan harga Rp' . number_format($request->harga, 2, ',', '.'),
]);
        return redirect()->route('pembayaran.token')->with('success', 'Pembelian token listrik berhasil dilakukan!');
    }

    // Simulasi pembayaran via QR
    public function bayarQr(Request $request)
    {

        $riwayat = Pembayaran::where('user_id', Auth::id())
            ->where('jenis', 'qr')
            ->latest()
            ->get();
        return view('pembayaran.qr', compact('riwayat'));
    }

    public function prosesQr(Request $request) {
        $request->validate([
        'merchant' => 'required|string',
        'bank' => 'nullable|string',
        'lokasi' => 'nullable|string',
        'nominal' => 'required|numeric',
    ]);

    $user = Auth::user();
    $harga = $request->nominal;


    // Cek apakah saldo cukup
    if ($user->saldo < $harga) {
        return back()->with('error', 'Saldo tidak mencukupi untuk pembayaran QRIS.');
    }

    // Potong saldo
    $user->saldo -= $harga;
    $user->save();

    // Buat keterangan transaksi
    $keterangan = "Merchant: {$request->merchant}\n" .
                  "Bank: " . ($request->bank ?? '-') . "\n" .
                  "Lokasi: " . ($request->lokasi ?? '-') . "\n" .
                  "Nominal: Rp" . number_format($harga, 0, ',', '.') . ",00";
    $keterangan = nl2br($keterangan);

    // Simpan ke tabel pembayaran
    Pembayaran::create([
        'user_id' => $user->id,
        'jenis' => 'qr',
        'tujuan' => $request->merchant,
        'jumlah' => $harga,
        'keterangan' => $keterangan,
    ]);

    RiwayatTransaksi::create([
        'user_id' => Auth::id(),
        'tipe' => 'pengeluaran',
        'kategori' => 'qr',
        'jumlah' => $harga,
        'deskripsi' => 'Pembayaran QR ke Merchant ' . $request->merchant .  ' sebesar Rp' . number_format($harga, 2, ',', '.'),
]);

    return redirect()->route('pembayaran.qr')->with('success', 'Pembayaran QRIS berhasil dilakukan!');
    }

    public function investasiDollar(Request $request)
    {
        $riwayat = Investasi::where('user_id', Auth::id())
            ->where('jenis', 'dollar')
            ->latest()
            ->get();
        $latestRate = Investasi::where('user_id', Auth::id())
            ->where('jenis', 'dollar')
            ->latest()
            ->first()->rate ?? 0;
        return view('pembayaran.investasi.dollar', compact('riwayat', 'latestRate'));
    }

    public function getDollarRate() {
        $response = Http::get('https://wise.com/rates/history+live', [
            'source' => 'USD',
            'target' => 'IDR',
            'length' => 1,
            'resolution' => 'hourly',
            'unit' => 'day',
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Gagal mengambil data'], 500);

    }

   public function investasiDollarInvest(Request $request)
    {
        $request->validate([
            'aksi' => 'required|in:beli,jual',
            'jumlah' => 'required|numeric|not_in:0',
            'rate' => 'required|numeric'
        ]);

        $user = Auth::user();
        $aksi = $request->aksi;
        $jumlah = $request->jumlah;
        $rate = $request->rate;
        $idr = $jumlah * $rate;

        if ($aksi === 'beli') {
            if ($user->saldo < $idr) {
                return back()->with('error', 'Saldo IDR tidak cukup untuk membeli.');
            }

            $user->saldo -= $idr;
            $user->saldo_dollar += $jumlah;

             RiwayatTransaksi::create([
                'user_id' => Auth::id(),
                'tipe' => 'pengeluaran',
                'kategori' => 'invest_dollar',
                'jumlah' => $idr,
                'deskripsi' => 'Invest $' . $jumlah . ' dengan rate Rp'. $rate.' sebesar Rp' . number_format($idr, 2, ',', '.'),
            ]);
        } elseif ($aksi === 'jual') {
            if ($user->saldo_dollar < $jumlah) {
                return back()->with('error', 'Saldo USD tidak cukup untuk menjual.');
            }

            $user->saldo_dollar -= $jumlah;
            $user->saldo += $idr;

            RiwayatTransaksi::create([
                'user_id' => Auth::id(),
                'tipe' => 'pemasukan',
                'kategori' => 'invest_dollar',
                'jumlah' => $idr,
                'deskripsi' => 'Jual $' . $jumlah . ' dengan rate Rp'. $rate.' sebesar Rp' . number_format($idr, 2, ',', '.'),
            ]);

        }

        $user->save();

        $lastInvest = Investasi::where('user_id', auth()->id())
            ->where('jenis', 'dollar')
            ->latest()
            ->first();

        $rateTerakhir = $lastInvest->rate ?? 0;
        $rateSekarang = $request->rate;

        $selisihRate = $rateSekarang - $rateTerakhir;
        $persen = $rateTerakhir > 0 ? ($selisihRate / $rateTerakhir) * 100 : 0;

        Investasi::create([
            'user_id' => $user->id,
            'jenis' => 'dollar',
            'jumlah' => $jumlah,
            'rate' => $rate,
            'aksi' => $aksi,
            'selisih' => $persen
        ]);

        return back()->with('success', 'Transaksi berhasil!');
    }

    public function adminIndex(Request $request) {
         $pembayaran = Pembayaran::with('user')->latest()->get();
         $investasi = Investasi::with('user')->latest()->get();

    return view('admin.pembayaran.index', [
        "pembayaran" => $pembayaran,
        "investasi" => $investasi
    ]);
    }
}

