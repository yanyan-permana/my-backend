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
        $penerimaanLangsung = PenerimaanLangsung::all();
        return new PenerimaanLangsungResource(true, 'List Data Penerimaan Langsung', $penerimaanLangsung);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'usr_id' => 'required',
            'trans_jns' => 'required',
            'tpl_nomor' => 'required',
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
            'trans_jns' => $request->trans_jns,
            'tpl_nomor' => $request->tpl_nomor,
            'tpl_tanggal' => $request->tpl_tanggal,
            'tpl_nominal' => $request->tpl_nominal,
            'tpl_keterangan' => $request->tpl_keterangan,
        ]);
        return new PenerimaanLangsungResource(true, 'Data Penerimaan Langsung Berhasil Ditambahkan!', $penerimaanLangsung);
    }

    public function show($id)
    {
        $penerimaanLangsung = PenerimaanLangsung::where('tpl_id', $id)->first();
        if ($penerimaanLangsung) {
            return new PenerimaanLangsungResource(true, 'Data Penerimaan Langsung Ditemukan!', $penerimaanLangsung);
        } else {
            return new PenerimaanLangsungResource(false, 'Data Penerimaan Langsung Tidak Ditemukan!', null);
        }
    }

    public function update(Request $request, PenerimaanLangsung $penerimaanLangsung)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'usr_id' => 'required',
            'trans_jns' => 'required',
            'tpl_nomor' => 'required',
            'tpl_tanggal' => 'required',
            'tpl_nominal' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $penerimaanLangsung->update([
            'usr_id' => $request->usr_id,
            'trans_jns' => $request->trans_jns,
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
}
