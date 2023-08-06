<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenerimaanLangsungResource;
use App\Models\PenerimaanLangsung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenerimaanLangsungController extends Controller
{
    public function index()
    {
        $penerimaanLangsung = PenerimaanLangsung::with(['user', 'jenisTransaksi'])->get()
            ->map(function ($penerimaanLangsung) {
                return [
                    'tpl_id' => $penerimaanLangsung->tpl_id,
                    'usr_id' => $penerimaanLangsung->usr_id,
                    'trans_jns' => $penerimaanLangsung->trans_jns,
                    'tpl_nomor' => $penerimaanLangsung->tpl_nomor,
                    'tpl_tanggal' => $penerimaanLangsung->tpl_tanggal,
                    'tpl_nominal' => $penerimaanLangsung->tpl_nominal,
                    'tpl_keterangan' => $penerimaanLangsung->tpl_keterangan,
                    'created_at' => $penerimaanLangsung->created_at,
                    'updated_at' => $penerimaanLangsung->updated_at,
                    'usr_login' => $penerimaanLangsung->user->usr_login,
                    'trx_nama' => $penerimaanLangsung->jenisTransaksi->trx_nama,
                ];
            });
        return new PenerimaanLangsungResource(true, 'List Data Penerimaan Langsung', $penerimaanLangsung);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'usr_id' => 'required',
            'trx_id' => 'required',
            'tpl_nomor' => 'required|unique:App\Models\PenerimaanLangsung,tpl_nomor',
            'tpl_tanggal' => 'required',
            'tpl_nominal' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // input penerimaanLangsung
        $penerimaanLangsung = PenerimaanLangsung::create([
            'usr_id' => $request->usr_id,
            'trx_id' => $request->trx_id,
            'trans_jns' => 'penerimaan',
            'tpl_nomor' => $request->tpl_nomor,
            'tpl_tanggal' => $request->tpl_tanggal,
            'tpl_nominal' => $request->tpl_nominal,
            'tpl_keterangan' => $request->tpl_keterangan,
        ]);
        return new PenerimaanLangsungResource(true, 'Data Penerimaan Langsung Berhasil Ditambahkan!', $penerimaanLangsung);
    }

    public function show($id)
    {
        $penerimaanLangsung = PenerimaanLangsung::where('tpl_id', $id)->with(['user', 'jenisTransaksi'])->first();
        if ($penerimaanLangsung) {
            $result = [
                'tpl_id' => $penerimaanLangsung->tpl_id,
                'usr_id' => $penerimaanLangsung->usr_id,
                'trans_jns' => $penerimaanLangsung->trans_jns,
                'tpl_nomor' => $penerimaanLangsung->tpl_nomor,
                'tpl_tanggal' => $penerimaanLangsung->tpl_tanggal,
                'tpl_nominal' => $penerimaanLangsung->tpl_nominal,
                'tpl_keterangan' => $penerimaanLangsung->tpl_keterangan,
                'created_at' => $penerimaanLangsung->created_at,
                'updated_at' => $penerimaanLangsung->updated_at,
                'usr_login' => $penerimaanLangsung->user->usr_login,
                'trx_nama' => $penerimaanLangsung->jenisTransaksi->trx_nama,
            ];
            return new PenerimaanLangsungResource(true, 'Data Penerimaan Langsung Ditemukan!', $result);
        } else {
            return new PenerimaanLangsungResource(false, 'Data Penerimaan Langsung Tidak Ditemukan!', null);
        }
    }

    public function update(Request $request, PenerimaanLangsung $penerimaanLangsung)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'usr_id' => 'required',
            'trx_id' => 'required',
            'tpl_nomor' => 'required|exists:App\Models\PenerimaanLangsung,tpl_nomor',
            'tpl_tanggal' => 'required',
            'tpl_nominal' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $penerimaanLangsung->update([
            'usr_id' => $request->usr_id,
            'trx_id' => $request->trx_id,
            'tpl_nomor' => $request->tpl_nomor,
            'tpl_tanggal' => $request->tpl_tanggal,
            'tpl_nominal' => $request->tpl_nominal,
            'tpl_keterangan' => $request->tpl_keterangan,
        ]);
        return new PenerimaanLangsungResource(true, 'Data Penerimaan Langsung Berhasil Diubah!', $penerimaanLangsung);
    }

    public function destroy($id)
    {
        $penerimaanLangsung = PenerimaanLangsung::where('tpl_id', $id)->first();
        if ($penerimaanLangsung) {
            $penerimaanLangsung->delete();
            return new PenerimaanLangsungResource(true, 'Data Penerimaan Langsung Berhasil Dihapus!', null);
        } else {
            return new PenerimaanLangsungResource(false, 'Data Penerimaan Langsung Tidak Ditemukan!', null);
        }
    }

    public function getNomor()
    {
        $result = PenerimaanLangsung::generateTplNumber();
        if ($result) {
            return new PenerimaanLangsungResource(true, 'TPL Nomor Ditemukan!', $result);
        } else {
            return new PenerimaanLangsungResource(false, 'TPL Nomor Tidak Ditemukan!', null);
        }
    }
}
