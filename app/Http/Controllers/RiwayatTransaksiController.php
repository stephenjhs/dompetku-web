<?php

namespace App\Http\Controllers;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

class RiwayatTransaksiController extends Controller
{

public function index()
{
   $riwayat_transaksi = RiwayatTransaksi::where('user_id', Auth::id())->with('user')->latest()->get();
$pemasukan_hari_ini = RiwayatTransaksi::where('user_id', Auth::id())
    ->where('tipe', 'pemasukan')
    ->whereDate('created_at', Carbon::today())
    ->sum('jumlah');

$pengeluaran_hari_ini = RiwayatTransaksi::where('user_id', Auth::id())
    ->where('tipe', 'pengeluaran')
    ->whereDate('created_at', Carbon::today())
    ->sum('jumlah');

// Bulan ini
$pemasukan_bulan_ini = RiwayatTransaksi::where('user_id', Auth::id())
    ->where('tipe', 'pemasukan')
    ->whereMonth('created_at', Carbon::now()->month)
    ->whereYear('created_at', Carbon::now()->year)
    ->sum('jumlah');

$pengeluaran_bulan_ini = RiwayatTransaksi::where('user_id', Auth::id())
    ->where('tipe', 'pengeluaran')
    ->whereMonth('created_at', Carbon::now()->month)
    ->whereYear('created_at', Carbon::now()->year)
    ->sum('jumlah');

// Total keseluruhan
$total_pemasukan = RiwayatTransaksi::where('user_id', Auth::id())->where('tipe', 'pemasukan')->sum('jumlah');
$total_pengeluaran = RiwayatTransaksi::where('user_id', Auth::id())->where('tipe', 'pengeluaran')->sum('jumlah');

// Saldo akhir
$saldo_akhir = $total_pemasukan - $total_pengeluaran;
    return view('riwayat-transaksi.index', compact('riwayat_transaksi', 'pemasukan_hari_ini', 'pengeluaran_hari_ini',
    'pemasukan_bulan_ini', 'pengeluaran_bulan_ini',
    'total_pemasukan', 'total_pengeluaran', 'saldo_akhir'));
}

}
