<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $fillable = ['nis', 'nama', 'kelas', 'no_hp', 'status'];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}