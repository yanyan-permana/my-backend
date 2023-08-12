<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LaporanPenerimaanResource;
use App\Models\LaporanPenerimaan;
use App\Models\LaporanRincianPenerimaan;
use Illuminate\Http\Request;

class LaporanPenerimaanController extends Controller
{
    public function index()
    {
        $result = LaporanPenerimaan::all();
        if ($result) {
            return new LaporanPenerimaanResource(true, 'Laporan Penerimaan!', $result);
        } else {
            return new LaporanPenerimaanResource(false, 'Laporan Penerimaan Tidak Ditemukan!', $result);
        }
    }

    public function getRincianPenerimaan($id)
    {
        $result = LaporanRincianPenerimaan::where('trx_id', $id)->get();
        if ($result) {
            return new LaporanPenerimaanResource(true, 'Laporan Penerimaan!', $result);
        } else {
            return new LaporanPenerimaanResource(false, 'Laporan Penerimaan Tidak Ditemukan!', $result);
        }
    }

    public function getRincianPenerimaanByDate(Request $request)
    {
        $startTanggal = $request->input("tanggal_awal");
        $endTanggal = $request->input("tanggal_akhir");
        $result = LaporanRincianPenerimaan::whereBetween('tpl_tanggal', [$startTanggal, $endTanggal])->get();
        if ($result) {
            return new LaporanPenerimaanResource(true, 'Laporan Penerimaan!', $result);
        } else {
            return new LaporanPenerimaanResource(false, 'Laporan Penerimaan Tidak Ditemukan!', $result);
        }
    }
}
