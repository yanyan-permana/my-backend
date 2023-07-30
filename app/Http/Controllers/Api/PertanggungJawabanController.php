<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PertanggungJawabanResource;
use App\Models\PertanggungJawaban;
use App\Models\RealisasiPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PertanggungJawabanController extends Controller
{
    public function index()
    {
        $realisasi = PertanggungJawaban::with('realisasi')->get()
            ->map(function ($data) {
                return [
                    'real_id' => $data->real_id,
                    'tgjwb_id' => $data->tgjwb_id,
                    'tgjwb_keterangan' => $data->tgjwb_keterangan,
                    'tgjwb_nominal' => $data->tgjwb_nominal,
                    'tgjwb_nomor' => $data->tgjwb_nomor,
                    'b_tanggal' => $data->b_tanggal,
                    'trans_jns' => $data->trans_jns,
                    'real_nomor' => $data->realisasi->real_nomor,
                    'real_nominal' => $data->realisasi->real_nominal,
                ];
            });
        return new PertanggungJawabanResource(true, 'List Data Realisasi', $realisasi);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'real_id' => 'required',
            'trans_jns' => 'required',
            'tgjwb_nomor' => 'required|unique:App\Models\PertanggungJawaban,tgjwb_nomor',
            'tgjwb_tanggal' => 'required',
            'tgjwb_nominal' => 'required',
            'tgjwb_keterangan' => 'string',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $realisasi = PertanggungJawaban::create([
            'real_id' => $request->real_id,
            'trans_jns' => $request->trans_jns,
            'tgjwb_nomor' => $request->tgjwb_nomor,
            'tgjwb_tanggal' => $request->tgjwb_tanggal,
            'tgjwb_nominal' => $request->tgjwb_nominal,
            'tgjwb_keterangan' => $request->tgjwb_keterangan,
        ]);
        return new PertanggungJawabanResource(true, 'Data Realisasi Berhasil Ditambahkan!', $realisasi);
    }

    public function show($id)
    {
        $realisasi = PertanggungJawaban::where('tgjwb_id', $id)->first();
        if ($realisasi) {
            return new PertanggungJawabanResource(true, 'Data realisasi Ditemukan!', $realisasi);
        } else {
            return new PertanggungJawabanResource(false, 'Data realisasi Tidak Ditemukan!', null);
        }
    }

    public function update(Request $request, PertanggungJawaban $realisasi)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'real_id' => 'required',
            'trans_jns' => 'required',
            'tgjwb_nomor' => 'required',
            'tgjwb_tanggal' => 'required',
            'tgjwb_nominal' => 'required',
            'tgjwb_keterangan' => 'string',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $realisasi->update([
            'real_id' => $request->real_id,
            'trans_jns' => $request->trans_jns,
            'tgjwb_nomor' => $request->tgjwb_nomor,
            'tgjwb_tanggal' => $request->tgjwb_tanggal,
            'tgjwb_nominal' => $request->tgjwb_nominal,
            'tgjwb_keterangan' => $request->tgjwb_keterangan,
        ]);
        return new PertanggungJawabanResource(true, 'Data Realisasi Berhasil Diubah!', $realisasi);
    }

    public function destroy($id)
    {
        $realisasi = PertanggungJawaban::where('tgjwb_id', $id)->first();
        if ($realisasi) {
            $realisasi->delete();
            return new PertanggungJawabanResource(true, 'Data Pengajuan Berhasil Dihapus!', null);
        } else {
            return new PertanggungJawabanResource(false, 'Data Pengajuan Tidak Ditemukan!', null);
        }
    }

    public function loadRealisasi()
    {
        $result = RealisasiPengajuan::has('pertanggungJawaban', '=', 0)->get();
        if ($result) {
            return new PertanggungJawabanResource(true, 'Pengajuan Ditemukan!', $result);
        } else {
            return new PertanggungJawabanResource(false, 'Pengajuan Tidak Ditemukan!', null);
        }
    }

    public function getNomor()
    {
        $result = PertanggungJawaban::generatePjNumber();
        if ($result) {
            return new PertanggungJawabanResource(true, 'Realisasi Nomor Ditemukan!', $result);
        } else {
            return new PertanggungJawabanResource(false, 'Realisasi Nomor Tidak Ditemukan!', null);
        }
    }
}
