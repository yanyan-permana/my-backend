<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\JenisTransaksi;
use App\Models\PenerimaanLangsung;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class JenisTransaksiPenerimaanController extends Controller
{
    public function index()
    {
        $penerimaan = JenisTransaksi::where('trx_kategori', 'penerimaan')->get();
        return view('penerimaan.index', compact('penerimaan'));
    }

    public function create()
    {
        return view('penerimaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'trx_nama' => 'required',
        ]);
        
        $jenisTransaksi = JenisTransaksi::create([
            'trx_nama' => $request->trx_nama,
            'trx_kategori' => 'penerimaan',
        ]);

        return redirect('/jenis-transaksi-penerimaan')->with('success', 'Data Penerimaan Berhasil Ditambahkan!');
    }

    public function edit(Request $request, $id)
    {
        $jenisTransaksi = JenisTransaksi::find($id);
        return view('penerimaan.edit', compact('jenisTransaksi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'trx_nama' => 'required',
        ]);
        
        $jenisTransaksi = JenisTransaksi::find($id);
        $jenisTransaksi->update([
            'trx_nama' => $request->trx_nama,
        ]);

        return redirect('/jenis-transaksi-penerimaan')->with('success', 'Data Penerimaan Berhasil Diubah!');
    }

    public function destroy($id)
    {
        $jenisTransaksi = JenisTransaksi::where('trx_id', $id)->first();
        if ($jenisTransaksi) {
            $isUsedPenerimaan = PenerimaanLangsung::where('trans_jns', $id)->exists();
            $isUsedPengajuan = Pengajuan::where('trx_id', $id)->exists();
            if ($isUsedPenerimaan) {
                return redirect('/jenis-transaksi-penerimaan')->with('error', 'Data Jenis Transaksi Sudah digunakan pada Penerimaan Langsung!');
            }
            if ($isUsedPengajuan) {
                return redirect('/jenis-transaksi-penerimaan')->with('success', 'Data Jenis Transaksi Sudah digunakan pada Pengajuan Pengeluaran!');
            }
            $jenisTransaksi->delete();
            return redirect('/jenis-transaksi-penerimaan')->with('success', 'Data Jenis Transaksi Berhasil Dihapus!');
        } else {
            return redirect('/jenis-transaksi-penerimaan')->with('success', 'Data Jenis Transaksi Tidak Ditemukan!');
        }
    }
}
