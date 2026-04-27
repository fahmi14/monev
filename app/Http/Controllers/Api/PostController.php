<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Petugas;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'nama' => 'required|string',
            'tahun' => 'required|digits:4',

            'petugas' => 'required|array',
            'petugas.*.nama' => 'required|string',
            'petugas.*.email' => 'nullable|email',

            'petugas.*.open' => 'nullable|integer|min:0',
            'petugas.*.submit' => 'nullable|integer|min:0',
            'petugas.*.reject' => 'nullable|integer|min:0',
            'petugas.*.approve' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            // SIMPAN KEGIATAN
            $kegiatan = Kegiatan::updateOrCreate(
                [
                    'nama' => $request->nama,
                    'tahun' => $request->tahun
                ],
                [
                    'updated_at' => now()
                ]
            );

            $kegiatan->touch();

            // SIMPAN PETUGAS
            $petugasData = [];

            foreach ($request->petugas as $p) {
                $petugasData[] = [
                    'nama' => $p['nama'],
                    'email' => $p['email'] ?? null,
                    'id_kegiatan' => $kegiatan->id,
                    'open' => $p['open'] ?? 0,
                    'submit' => $p['submit'] ?? 0,
                    'reject' => $p['reject'] ?? 0,
                    'approve' => $p['approve'] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // INSERT BATCH (lebih cepat 🔥)
            Petugas::upsert(
                $petugasData,
                ['id_kegiatan', 'email'], // unique key
                ['nama', 'open', 'submit', 'reject', 'approve', 'updated_at'] // field yg diupdate
            );

            DB::commit();

            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $kegiatan->load('petugas')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}