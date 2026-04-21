<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugass';
    protected $fillable = [
        'id_kegiatan',
        'nama',
        'email',
        'open',
        'submit',
        'reject',
        'approve',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan');
    }
}
