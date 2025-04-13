<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investasi extends Model
{
    use HasFactory;

    protected $table = "investasi";

    protected $fillable = [
        'user_id',
        'jenis',
        'jumlah',
        'rate',
        'selisih',
        'aksi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hitung total IDR yang dibelanjakan saat investasi
     */
    public function totalIDR()
    {
        return $this->jumlah * $this->rate;
    }
}
