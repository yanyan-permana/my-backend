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
        return new LaporanPenerimaanResource(true, 'Laporan Penerimaan', $result);
    }

    public function getRincianPenerimaan($id)
    {
        $result = LaporanRincianPenerimaan::where('trx_id', $id)->get();
        return new LaporanPenerimaanResource(true, 'Laporan Penerimaan', $result);
    }
}
