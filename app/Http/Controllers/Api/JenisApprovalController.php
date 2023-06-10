<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JenisApprovalResource;
use App\Models\JenisApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisApprovalController extends Controller
{
    public function index()
    {
        $jenisApproval = JenisApproval::all();
        return new JenisApprovalResource(true, 'List Data Jenis Approval', $jenisApproval);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'app_jenis' => 'required',
            'app_nama' => 'required',
            'app_min_nom' => 'required',
            'app_max_nom' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // input jenisApproval
        $jenisApproval = JenisApproval::create([
            'app_jenis' => $request->app_jenis,
            'app_nama' => $request->app_nama,
            'app_min_nom' => $request->app_min_nom,
            'app_max_nom' => $request->app_max_nom,
        ]);
        return new JenisApprovalResource(true, 'Data Jenis Approval Berhasil Ditambahkan!', $jenisApproval);
    }

    public function show($id)
    {
        $jenisApproval = JenisApproval::where('app_id', $id)->first();
        if ($jenisApproval) {
            return new JenisApprovalResource(true, 'Data Jenis Approval Ditemukan!', $jenisApproval);
        } else {
            return new JenisApprovalResource(false, 'Data Jenis Approval Tidak Ditemukan!', null);
        }
    }

    public function update(Request $request, JenisApproval $jenisApproval)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'app_jenis' => 'required',
            'app_nama' => 'required',
            'app_min_nom' => 'required',
            'app_max_nom' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $jenisApproval->update([
            'app_jenis' => $request->app_jenis,
            'app_nama' => $request->app_nama,
            'app_min_nom' => $request->app_min_nom,
            'app_max_nom' => $request->app_max_nom,
        ]);
        return new JenisApprovalResource(true, 'Data Jenis Approval Berhasil Diubah!', $jenisApproval);
    }

    public function destroy($id)
    {
        $jenisApproval = JenisApproval::where('app_id', $id)->first();
        if ($jenisApproval) {
            $jenisApproval->delete();
            return new JenisApprovalResource(true, 'Data Jenis Approval Berhasil Dihapus!', null);
        } else {
            return new JenisApprovalResource(false, 'Data Jenis Approval Tidak Ditemukan!', null);
        }
    }
}
