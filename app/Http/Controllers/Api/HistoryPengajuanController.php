<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryPengajuanResource;
use App\Models\ViewHistoryPengajuan;
use Illuminate\Http\Request;

class HistoryPengajuanController extends Controller
{
    public function index()
    {
        $result = ViewHistoryPengajuan::all();
        return new HistoryPengajuanResource(true, 'List Data History Pengajuan', $result);
    }

    public function getByUser($id)
    {
        $result = ViewHistoryPengajuan::where('kry_id', $id)->orderBy('aju_tanggal', 'desc')->get();
        if ($result) {
            return new HistoryPengajuanResource(true, 'Data History Pengajuan Ditemukan!', $result);
        } else {
            return new HistoryPengajuanResource(false, 'Data History Pengajuan Tidak Ditemukan!', null);
        }
    }

    public function show($id)
    {
        $result = ViewHistoryPengajuan::where('app_id', $id)->first();
        if ($result) {
            return new HistoryPengajuanResource(true, 'Data History Pengajuan Ditemukan!', $result);
        } else {
            return new HistoryPengajuanResource(false, 'Data History Pengajuan Tidak Ditemukan!', null);
        }
    }
}
