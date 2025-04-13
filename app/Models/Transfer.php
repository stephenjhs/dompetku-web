<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    // Nama tabel eksplisit
    protected $table = 'transfer';

    // Kolom yang bisa diisi
    protected $fillable = [
    'dari_user_id',
    'ke_user_id',
    'ke_nama',
    'ke_tipe',
    'ke_nomor',
    'jumlah',
    'status',
];


    public function dariUser()
    {
        return $this->belongsTo(User::class, 'dari_user_id');
    }

    public function keUser()
    {
        return $this->belongsTo(User::class, 'ke_user_id');
    }
}
