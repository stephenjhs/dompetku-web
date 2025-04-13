<?php
// app/Models/Transaksi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatTransaksi extends Model
{

    protected $table = "riwayat_transaksi";
    protected $fillable = [
        'user_id', 'tipe', 'kategori', 'jumlah', 'deskripsi',
    ];

     public function user()
    {   
        return $this->belongsTo(User::class);
    }
}
