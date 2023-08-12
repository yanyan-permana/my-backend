<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ViewDashboardResource;
use App\Models\ViewDashboard;
use App\Models\ViewDashboardPerKaryawan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $result = ViewDashboard::first();
        if ($result) {
            return new ViewDashboardResource(true, 'Data Ditemukan!', $result);
        } else {
            return new ViewDashboardResource(false, 'Data Tidak Ditemukan!', null);
        }
    }

    public function getByKaryawanId($id)
    {
        $result = ViewDashboardPerKaryawan::where('kry_id', $id)->first();
        if ($result) {
            return new ViewDashboardResource(true, 'Data Ditemukan!', $result);
        } else {
            return new ViewDashboardResource(false, 'Data Tidak Ditemukan!', null);
        }
    }

    public function getAllByKaryawan()
    {
        $result = ViewDashboardPerKaryawan::all();
        if ($result) {
            return new ViewDashboardResource(true, 'Data Ditemukan!', $result);
        } else {
            return new ViewDashboardResource(false, 'Data Tidak Ditemukan!', null);
        }
    }
}
