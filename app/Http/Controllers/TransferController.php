<?php
namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\User;
use App\Models\RiwayatTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function index()
    {
        $riwayat = Transfer::where('dari_user_id', Auth::id())
            ->latest()
            ->get();
        return view('transfer.index', compact('riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ke_tipe' => 'required|in:dompetku,dana,ovo,gopay,bri,bni,mandiri',
            'ke_nomor' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        $user = Auth::user();

        if ($user->saldo < $request->jumlah) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        $ke_user_id = null;
        $ke_nama = ucfirst($request->ke_tipe);

        if ($request->ke_tipe === 'dompetku') {
            if($request->ke_nomor === Auth::user()->phone_number) {
                return back()->with('error', 'Kamu tidak bisa mentransfer ke akun DompetMu sendiri.');
            }
            $penerima = User::where('phone_number', $request->ke_nomor)->first();
            if (!$penerima) {
                return back()->with('error', 'Pengguna DompetKu tidak ditemukan.');
            }

            $ke_user_id = $penerima->id;
            $ke_nama = $penerima->name;
        }

        $user->saldo -= $request->jumlah;
        $user->save();

        if ($ke_user_id) {
            $penerima->saldo += $request->jumlah;
            $penerima->save();

            RiwayatTransaksi::create([
                'user_id' => $penerima->id,
                'tipe' => 'pemasukan',
                'kategori' => 'transfer',
                'jumlah' => $request->jumlah, 
                'deskripsi' => 'Mendapatkan transferan saldo DompetKu sebesar Rp' . number_format($request->jumlah, 2, ',', '.') . ' dari ' . $user->name,
            ]);
        }

        Transfer::create([
            'dari_user_id' => $user->id,
            'ke_user_id' => $ke_user_id,
            'ke_nama' => $ke_nama,
            'ke_tipe' => $request->ke_tipe,
            'ke_nomor' => $request->ke_nomor,
            'jumlah' => $request->jumlah,
            'status' => 'berhasil',
        ]);

        RiwayatTransaksi::create([
                'user_id' => Auth::id(),
                'tipe' => 'pengeluaran',
                'kategori' => 'transfer', 
                'jumlah' => $request->jumlah, 
                'deskripsi' => 'Transfer saldo ' . $request->ke_tipe . ' sebesar Rp' . number_format($request->jumlah, 2, ',', '.') . ' ke nomor ' . $request->ke_nomor,
            ]);

        return redirect()->route('transfer.index')->with('success', 'Transfer berhasil dilakukan!');
    }

    public function adminIndex(Request $request) {
        $transfers = Transfer::with('dariUser')->latest()->get();
    return view('admin.transfer.index', compact('transfers'));

    }
}
