<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'nama',
        'tahun',
    ];

    public function petugas()
    {
        return $this->hasMany(Petugas::class, 'id_kegiatan');
    }
}
