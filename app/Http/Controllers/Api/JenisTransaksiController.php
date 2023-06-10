<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JenisTransaksiResource;
use App\Models\JenisTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisTransaksiController extends Controller
{
    public function index()
    {
        $jenisTransaksi = JenisTransaksi::all();
        return new JenisTransaksiResource(true, 'List Data Jenis Transaksi', $jenisTransaksi);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'trx_nama' => 'required',
            'trx_kategori' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // input jenisTransaksi
        $jenisTransaksi = JenisTransaksi::create([
            'trx_nama' => $request->trx_nama,
            'trx_kategori' => $request->trx_kategori,
        ]);
        return new JenisTransaksiResource(true, 'Data Jenis Transaksi Berhasil Ditambahkan!', $jenisTransaksi);
    }

    public function show($id)
    {
        $jenisTransaksi = JenisTransaksi::where('trx_id', $id)->first();
        if ($jenisTransaksi) {
            return new JenisTransaksiResource(true, 'Data Jenis Transaksi Ditemukan!', $jenisTransaksi);
        } else {
            return new JenisTransaksiResource(false, 'Data Jenis Transaksi Tidak Ditemukan!', null);
        }
    }

    public function update(Request $request, JenisTransaksi $jenisTransaksi)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'trx_nama' => 'required',
            'trx_kategori' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $jenisTransaksi->update([
            'trx_nama' => $request->trx_nama,
            'trx_kategori' => $request->trx_kategori,
        ]);
        return new JenisTransaksiResource(true, 'Data Jenis Transaksi Berhasil Diubah!', $jenisTransaksi);
    }

    public function destroy($id)
    {
        $jenisTransaksi = JenisTransaksi::where('trx_id', $id)->first();
        if ($jenisTransaksi) {
            $jenisTransaksi->delete();
            return new JenisTransaksiResource(true, 'Data Jenis Transaksi Berhasil Dihapus!', null);
        } else {
            return new JenisTransaksiResource(false, 'Data Jenis Transaksi Tidak Ditemukan!', null);
        }
    }
}
