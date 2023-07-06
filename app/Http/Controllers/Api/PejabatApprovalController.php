<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PejabatApprovalResource;
use App\Models\PejabatApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PejabatApprovalController extends Controller
{
    public function index()
    {
        $pejabatApproval = PejabatApproval::query()->with("jenisApproval")->get();
        return new PejabatApprovalResource(true, 'List Data Pejabat Approval', $pejabatApproval);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'app_id' => 'required',
            'usr_id' => 'required',
            'app_auth_user' => 'required',
            'app_auth_password' => 'required',
            'pjbt_status' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // input pejabatApproval
        $pejabatApproval = PejabatApproval::create([
            'app_id' => $request->app_id,
            'usr_id' => $request->usr_id,
            'app_auth_user' => $request->app_auth_user,
            'app_auth_password' => $request->app_auth_password,
            'pjbt_status' => $request->pjbt_status,
        ]);
        return new PejabatApprovalResource(true, 'Data Pejabat Approval Berhasil Ditambahkan!', $pejabatApproval);
    }

    public function show($id)
    {
        $pejabatApproval = PejabatApproval::where('pjbt_id', $id)->with("jenisApproval")->first();
        if ($pejabatApproval) {
            return new PejabatApprovalResource(true, 'Data Pejabat Approval Ditemukan!', $pejabatApproval);
        } else {
            return new PejabatApprovalResource(false, 'Data Pejabat Approval Tidak Ditemukan!', null);
        }
    }

    public function update(Request $request, PejabatApproval $pejabatApproval)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'app_id' => 'required',
            'usr_id' => 'required',
            'app_auth_user' => 'required',
            'app_auth_password' => 'required',
            'pjbt_status' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $pejabatApproval->update([
            'app_id' => $request->app_id,
            'usr_id' => $request->usr_id,
            'app_auth_user' => $request->app_auth_user,
            'app_auth_password' => $request->app_auth_password,
            'pjbt_status' => $request->pjbt_status,
        ]);
        return new PejabatApprovalResource(true, 'Data Pejabat Approval Berhasil Diubah!', $pejabatApproval);
    }

    public function destroy($id)
    {
        $pejabatApproval = PejabatApproval::where('pjbt_id', $id)->first();
        if ($pejabatApproval) {
            $pejabatApproval->delete();
            return new PejabatApprovalResource(true, 'Data Pejabat Approval Berhasil Dihapus!', null);
        } else {
            return new PejabatApprovalResource(false, 'Data Pejabat Approval Tidak Ditemukan!', null);
        }
    }
}
