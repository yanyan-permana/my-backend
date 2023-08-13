<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LaporanPengeluaranResource;
use App\Models\LaporanPengeluaran;
use App\Models\LaporanRincianPengeluaran;
use Illuminate\Http\Request;

class LaporanPengeluaranController extends Controller
{
    public function index()
    {
        $result = LaporanPengeluaran::all();
        if ($result) {
            return new LaporanPengeluaranResource(true, 'Laporan Pengeluaran!', $result);
        } else {
            return new LaporanPengeluaranResource(false, 'Laporan Pengeluaran Tidak Ditemukan!', $result);
        }
    }

    public function getRincianPengeluaran($id)
    {
        $result = LaporanRincianPengeluaran::where('trx_id', $id)->get();
        if ($result) {
            return new LaporanPengeluaranResource(true, 'Laporan Pengeluaran!', $result);
        } else {
            return new LaporanPengeluaranResource(false, 'Laporan Pengeluaran Tidak Ditemukan!', $result);
        }
    }

    public function getRincianPengeluaranByDate(Request $request)
    {
        $startTanggal = $request->input("tanggal_awal");
        $endTanggal = $request->input("tanggal_akhir");
        $result = LaporanRincianPengeluaran::whereBetween('tpl_tanggal', [$startTanggal, $endTanggal])->get();
        if ($result) {
            return new LaporanPengeluaranResource(true, 'Laporan Pengeluaran!', $result);
        } else {
            return new LaporanPengeluaranResource(false, 'Laporan Pengeluaran Tidak Ditemukan!', $result);
        }
    }
}
