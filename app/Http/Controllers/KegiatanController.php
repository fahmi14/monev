<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::all();
        return view('kegiatan.index', compact('kegiatans'));
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::with('petugas')->find($id);

        if (!$kegiatan) {
            abort(404);
        }

        return view('kegiatan.show', compact('kegiatan'));
    }
}
