<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengajuanResource;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuan = Pengajuan::with("jenisTransaksi")->get()
            ->map(function ($pengajuan) {
                return [
                    'aju_id' => $pengajuan->aju_id,
                    'kry_id' => $pengajuan->kry_id,
                    'trx_id' => $pengajuan->trx_id,
                    'trx_nama' => $pengajuan->jenisTransaksi->trx_nama,
                    'aju_nomor' => $pengajuan->aju_nomor,
                    'aju_tanggal' => $pengajuan->aju_tanggal,
                    'aju_nominal' => $pengajuan->aju_nominal,
                    'aju_keterangan' => $pengajuan->aju_keterangan,
                    'created_at' => $pengajuan->created_at,
                    'updated_at' => $pengajuan->updated_at,
                ];
            });
        return new PengajuanResource(true, 'List Data Pengajuan', $pengajuan);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'kry_id' => 'required',
            'trx_id' => 'required',
            'aju_nomor' => 'required',
            'aju_tanggal' => 'required',
            'aju_nominal' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // input pengajuan
        $pengajuan = Pengajuan::create([
            'kry_id' => $request->kry_id,
            'trx_id' => $request->trx_id,
            'aju_nomor' => $request->aju_nomor,
            'aju_tanggal' => $request->aju_tanggal,
            'aju_nominal' => $request->aju_nominal,
            'aju_keterangan' => $request->aju_keterangan,
        ]);
        return new PengajuanResource(true, 'Data Pengajuan Berhasil Ditambahkan!', $pengajuan);
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::where('aju_id', $id)->with('jenisTransaksi')->first();
        if ($pengajuan) {
            $pengajuan = [
                'aju_id' => $pengajuan->aju_id,
                'kry_id' => $pengajuan->kry_id,
                'trx_id' => $pengajuan->trx_id,
                'trx_nama' => $pengajuan->jenisTransaksi->trx_nama,
                'aju_nomor' => $pengajuan->aju_nomor,
                'aju_tanggal' => $pengajuan->aju_tanggal,
                'aju_nominal' => $pengajuan->aju_nominal,
                'aju_keterangan' => $pengajuan->aju_keterangan,
                'created_at' => $pengajuan->created_at,
                'updated_at' => $pengajuan->updated_at,
            ];
            return new PengajuanResource(true, 'Data Pengajuan Ditemukan!', $pengajuan);
        } else {
            return new PengajuanResource(false, 'Data Pengajuan Tidak Ditemukan!', null);
        }
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'kry_id' => 'required',
            'trx_id' => 'required',
            'aju_nomor' => 'required',
            'aju_tanggal' => 'required',
            'aju_nominal' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $pengajuan->update([
            'kry_id' => $request->kry_id,
            'trx_id' => $request->trx_id,
            'aju_nomor' => $request->aju_nomor,
            'aju_tanggal' => $request->aju_tanggal,
            'aju_nominal' => $request->aju_nominal,
            'aju_keterangan' => $request->aju_keterangan,
        ]);
        return new PengajuanResource(true, 'Data Pengajuan Berhasil Diubah!', $pengajuan);
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::where('aju_id', $id)->first();
        if ($pengajuan) {
            $pengajuan->delete();
            return new PengajuanResource(true, 'Data Pengajuan Berhasil Dihapus!', null);
        } else {
            return new PengajuanResource(false, 'Data Pengajuan Tidak Ditemukan!', null);
        }
    }
}
