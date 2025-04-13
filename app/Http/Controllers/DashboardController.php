<?php

namespace App\Http\Controllers;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $riwayat_transaksi = RiwayatTransaksi::where('user_id', Auth::id())->with('user')->latest()->limit(5)->get();
$pemasukan_hari_ini = RiwayatTransaksi::where('user_id', Auth::id())
    ->where('tipe', 'pemasukan')
    ->whereDate('created_at', Carbon::today())
    ->sum('jumlah');

$pengeluaran_hari_ini = RiwayatTransaksi::where('user_id', Auth::id())
    ->where('tipe', 'pengeluaran')
    ->whereDate('created_at', Carbon::today())
    ->sum('jumlah');

    return view('dashboard', compact('riwayat_transaksi', 'pemasukan_hari_ini', 'pengeluaran_hari_ini'));
}

public function adminIndex(Request $request){
    return view('admin.dashboard');
}
}
