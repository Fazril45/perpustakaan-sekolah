<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = [
        'anggota_id', 'buku_id', 'tgl_pinjam',
        'tgl_jatuh_tempo', 'tgl_kembali', 'status', 'denda',
    ];

    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_jatuh_tempo' => 'date',
        'tgl_kembali' => 'date',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}