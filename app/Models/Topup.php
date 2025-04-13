<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    use HasFactory;

    // Nama tabel eksplisit
    protected $table = 'topup';

    // Kolom yang bisa diisi
    protected $fillable = [
        'user_id',
        'jumlah',
        'status',
        'keterangan',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
