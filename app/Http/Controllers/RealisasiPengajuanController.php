<?php

namespace App\Http\Controllers;

use App\Http\Resources\RealisasiPengajuanResource;
use App\Models\RealisasiPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RealisasiPengajuanController extends Controller
{
    public function index()
    {
        $realisasi = RealisasiPengajuan::all();
        return new RealisasiPengajuanResource(true, 'List Data Realisasi', $realisasi);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'aju_app_id' => 'required',
            'real_pjbt_id' => 'required',
            'real_nomor' => 'required',
            'real_tanggal' => 'required',
            'real_nominal' => 'required',
            'real_keterangan' => 'string',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $realisasi = RealisasiPengajuan::create([
            'aju_app_id' => $request->aju_app_id,
            'real_pjbt_id' => $request->real_pjbt_id,
            'real_nomor' => $request->real_nomor,
            'real_tanggal' => $request->real_tanggal,
            'real_nominal' => $request->real_nominal,
            'real_keterangan' => $request->real_keterangan,
        ]);
        return new RealisasiPengajuanResource(true, 'Data Realisasi Berhasil Ditambahkan!', $realisasi);
    }

    public function show($id)
    {
        $realisasi = RealisasiPengajuan::where('real_id', $id)->first();
        if ($realisasi) {
            return new RealisasiPengajuanResource(true, 'Data realisasi Ditemukan!', $realisasi);
        } else {
            return new RealisasiPengajuanResource(false, 'Data realisasi Tidak Ditemukan!', null);
        }
    }

    public function update(Request $request, RealisasiPengajuan $realisasi)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'aju_app_id' => 'required',
            'real_pjbt_id' => 'required',
            'real_nomor' => 'required',
            'real_tanggal' => 'required',
            'real_nominal' => 'required',
            'real_keterangan' => 'string',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $realisasi->update([
            'aju_app_id' => $request->aju_app_id,
            'real_pjbt_id' => $request->real_pjbt_id,
            'real_nomor' => $request->real_nomor,
            'real_tanggal' => $request->real_tanggal,
            'real_nominal' => $request->real_nominal,
            'real_keterangan' => $request->real_keterangan,
        ]);
        return new RealisasiPengajuanResource(true, 'Data Realisasi Berhasil Diubah!', $realisasi);
    }

    public function destroy($id)
    {
        $realisasi = RealisasiPengajuan::where('real_id', $id)->first();
        if ($realisasi) {
            $realisasi->delete();
            return new RealisasiPengajuanResource(true, 'Data Pengajuan Berhasil Dihapus!', null);
        } else {
            return new RealisasiPengajuanResource(false, 'Data Pengajuan Tidak Ditemukan!', null);
        }
    }
}
