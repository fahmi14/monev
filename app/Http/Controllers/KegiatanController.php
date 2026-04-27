<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Petugas;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::all();
        return view('kegiatan', compact('kegiatans'));
    }
public function show(Request $request, $id)
{
    $perPage = $request->get('perPage', 10);

    // whitelist biar aman
    $allowedPerPage = [10, 50, 100];
    if (!in_array($perPage, $allowedPerPage)) {
        $perPage = 10;
    }
    // ambil parameter sorting dari URL
    $sort = $request->get('sort', 'nama');        // default: nama
    $direction = $request->get('direction', 'asc'); // default: asc

    // whitelist kolom biar aman
    $allowed = ['nama','open','submit','reject','approve','progress'];
    if (!in_array($sort, $allowed)) {
        $sort = 'nama';
    }
    
    $kegiatan = Kegiatan::findOrFail($id);

    // base query
    $query = Petugas::where('id_kegiatan', $id);

    // sorting
    if ($sort == 'progress') {
        $query->orderByRaw('
            (submit + reject + approve) / 
            NULLIF((submit + reject + approve + open), 0) '.$direction.'
        ');
    } else {
        $query->orderBy($sort, $direction);
    }

    // pagination
    $petugass = $query->paginate($perPage)->withQueryString();

    // total summary
    $total = Petugas::selectRaw('
        SUM(submit) AS submit,
        SUM(reject) AS reject,
        SUM(open) AS open,
        SUM(approve) AS approve
    ')
    ->where('id_kegiatan', $id)
    ->groupBy('id_kegiatan')
    ->first();

    // kalau kosong
    if ($petugass->isEmpty()) {
        abort(404);
    }

    return view('dashboard.utama', compact('petugass','total','sort','direction','kegiatan','perPage'));
}

   public function download($id)
{
    
    $kegiatan = \App\Models\Kegiatan::findOrFail($id);
    $data = \App\Models\Petugas::where('id_kegiatan', $id)->get();

    $filename = "petugas_" . $kegiatan->nama . "_" . now()->format('d-m-Y_H-i-s') . ".xls";

    $headers = [
        "Content-Type" => "application/vnd.ms-excel",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $callback = function() use ($data) {
        echo "Nama\tEmail\tOpen\tSubmit\tReject\tApprove\n";

        foreach ($data as $row) {
            echo "{$row->nama}\t{$row->email}\t{$row->open}\t{$row->submit}\t{$row->reject}\t{$row->approve}\n";
        }
    };

    return response()->stream($callback, 200, $headers);
}
}
