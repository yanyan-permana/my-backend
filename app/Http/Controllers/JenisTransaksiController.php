<?php

namespace App\Http\Controllers;

use App\Models\JenisTransaksi;
use Illuminate\Http\Request;

class JenisApprovalController extends Controller
{
    public function index()
    {
        $jenisTransaksi = JenisTransaksi::all();
        return view('jenistransaksi.index', compact('jenisTransaksi'));
    }

    public function create()
    {
        return view('jenistransaksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'trx_nama' => 'required',
            'trx_kategori' => 'required',
        ]);

        JenisTransaksi::create([
            'trx_nama' => $request->trx_nama,
            'trx_kategori' => $request->trx_kategori,
        ]);

        return redirect('/jenis-transaksi')->with('success', 'Data Jenis Approval Berhasil Ditambahkan!');
    }

    public function edit(JenisTransaksi $jenisTransaksi)
    {
        return view('jenistransaksi.edit', compact('jenisTransaksi'));
    }

    public function update(Request $request, JenisTransaksi $jenisTransaksi)
    {
        $request->validate([
            'trx_nama' => 'required',
            'trx_kategori' => 'required',
        ]);

        $jenisTransaksi->update([
            'trx_nama' => $request->trx_nama,
            'trx_kategori' => $request->trx_kategori,
        ]);
        
        return redirect('/jenis-transaksi')->with('success', 'Data Jenis Approval Berhasil Diubah!');
    }

    public function destroy($id)
    {
        $jenisTransaksi = JenisTransaksi::where('trx_id', $id)->first();

        if ($jenisTransaksi) {
            $jenisTransaksi->delete();
            return redirect('/jenis-transaksi')->with('success', 'Data Jenis Approval Berhasil Dihapus!');
        } else {
            return redirect('/jenis-transaksi')->with('error', 'Data Jenis Approval Tidak Ditemukan!');
        }
    }
}
