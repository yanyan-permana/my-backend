<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\JenisTransaksi;
use App\Models\PenerimaanLangsung;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class JenisTransaksiPengeluaranController extends Controller
{
    public function index()
    {
        $pengeluaran = JenisTransaksi::where('trx_kategori', 'pengeluaran')->get();
        return view('pengeluaran.index', compact('pengeluaran'));
    }

    public function create()
    {
        return view('pengeluaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'trx_nama' => 'required',
        ]);
        
        $jenisTransaksi = JenisTransaksi::create([
            'trx_nama' => $request->trx_nama,
            'trx_kategori' => 'pengeluaran',
        ]);

        return redirect('/jenis-transaksi-pengeluaran')->with('success', 'Data Penerimaan Berhasil Ditambahkan!');
    }

    public function edit(Request $request, $id)
    {
        $jenisTransaksi = JenisTransaksi::find($id);
        return view('pengeluaran.edit', compact('jenisTransaksi'));
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

        return redirect('/jenis-transaksi-pengeluaran')->with('success', 'Data Penerimaan Berhasil Diubah!');
    }

    public function destroy($id)
    {
        $jenisTransaksi = JenisTransaksi::where('trx_id', $id)->first();
        if ($jenisTransaksi) {
            $isUsedPenerimaan = PenerimaanLangsung::where('trans_jns', $id)->exists();
            $isUsedPengajuan = Pengajuan::where('trx_id', $id)->exists();
            if ($isUsedPenerimaan) {
                return redirect('/jenis-transaksi-pengeluaran')->with('error', 'Data Jenis Transaksi Sudah digunakan pada Penerimaan Langsung!');
            }
            if ($isUsedPengajuan) {
                return redirect('/jenis-transaksi-pengeluaran')->with('success', 'Data Jenis Transaksi Sudah digunakan pada Pengajuan Pengeluaran!');
            }
            $jenisTransaksi->delete();
            return redirect('/jenis-transaksi-pengeluaran')->with('success', 'Data Jenis Transaksi Berhasil Dihapus!');
        } else {
            return redirect('/jenis-transaksi-pengeluaran')->with('success', 'Data Jenis Transaksi Tidak Ditemukan!');
        }
    }
}
