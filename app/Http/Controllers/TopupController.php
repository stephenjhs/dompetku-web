<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topup;
use App\Models\User;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    // Menampilkan form topup (user)
    public function index()
    {
        $riwayat = Topup::where('user_id', Auth::id())->latest()->get();
        return view('topup.index', compact('riwayat'));
    }

    // Menyimpan permintaan topup (user)
    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Topup::create([
            'user_id' => Auth::id(),
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
        ]);

        return redirect()->route('topup.index')->with('success', 'Permintaan topup berhasil dikirim. Silakan tunggu konfirmasi dari admin.');
    }

    // Menampilkan daftar topup (admin)
    public function adminIndex()
    {
        $topups = Topup::with('user')->latest()->get();
        $totalTopup = Topup::sum('jumlah');
        return view('admin.topup.index', compact('topups', 'totalTopup'));
    }

    // Konfirmasi topup oleh admin
    public function verifikasi($id)
    {
        $topup = Topup::findOrFail($id);
        $topup->status = 'disetujui';
        $topup->save();

        // Tambahkan ke saldo user
        $user = $topup->user;
        $user->saldo += $topup->jumlah;
        $user->save();

        RiwayatTransaksi::create([
    'user_id' => $user->id,
        'tipe' => 'pemasukan', // karena ini topup, dianggap pemasukan ke akun user
        'kategori' => 'topup',
        'jumlah' => $topup->jumlah,
        'deskripsi' => 'Topup sebesar Rp' . number_format($topup->jumlah, 2, ',', '.'),
    ]);

        return back()->with('success', 'Topup telah disetujui dan saldo pengguna diperbarui.');
    }

    // Tolak topup oleh admin
    public function tolak($id)
    {
        $topup = Topup::findOrFail($id);
        $topup->status = 'ditolak';
        $topup->save();

        return back()->with('error', 'Topup telah ditolak.');
    }
}
