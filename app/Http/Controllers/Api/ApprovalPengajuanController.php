<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApprovalPengajuanResource;
use App\Models\ApprovalPengajuan;
use App\Models\JenisApproval;
use App\Models\PejabatApproval;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApprovalPengajuanController extends Controller
{
    public function getPengajuanById($ajuId)
    {
        $dataPengajuan = Pengajuan::where('aju_id', $ajuId)->with('approval')->first();
        if ($dataPengajuan) {
            return new ApprovalPengajuanResource(true, 'Data Pengajuan', $dataPengajuan);
        } else {
            return new ApprovalPengajuanResource(false, 'Pengajuan tidak ditemukan!', $dataPengajuan);
        }
    }

    public function getPengajuanVerifikasi(Request $request)
    {
        $statusApprove = $request->input('status_approve');

        $dataPengajuan = Pengajuan::with(['approval', 'jenisTransaksi'])
            ->whereDoesntHave('approval', function ($query) {
                $query->whereNull('aju_app_ver_status')
                    ->WhereNull('aju_app_keu_status')
                    ->WhereNull('aju_app_dir_status');
            });

        if ($statusApprove === 'disetujui') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_ver_status', '=', 'disetujui');
            });
        } elseif ($statusApprove === 'ditolak') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_ver_status', '=', 'ditolak');
            });
        }

        $dataPengajuan = $dataPengajuan->get();
        if ($dataPengajuan) {
            return new ApprovalPengajuanResource(true, 'List Pengajuan', $dataPengajuan);
        } else {
            return new ApprovalPengajuanResource(false, 'Pengajuan tidak ditemukan!', $dataPengajuan);
        }
    }

    public function getPengajuanKeuangan(Request $request)
    {
        $statusApprove = $request->input('status_approve');

        $dataPengajuan = Pengajuan::with(['approval', 'jenisTransaksi'])
            ->whereDoesntHave('approval', function ($query) {
                $query->whereNotNull('aju_app_ver_status')
                    ->WhereNull('aju_app_keu_status')
                    ->WhereNull('aju_app_dir_status');
            });

        if ($statusApprove === 'disetujui') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_keu_status', '=', 'disetujui');
            });
        } elseif ($statusApprove === 'ditolak') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_keu_status', '=', 'ditolak');
            });
        }

        $dataPengajuan = $dataPengajuan->get();
        return new ApprovalPengajuanResource(true, 'List Data Pengajuan', $dataPengajuan);
    }

    public function getPengajuanDireksi(Request $request)
    {
        $statusApprove = $request->input('status_approve');

        $dataPengajuan = Pengajuan::with(['approval', 'jenisTransaksi'])
            ->whereDoesntHave('approval', function ($query) {
                $query->whereNotNull('aju_app_ver_status')
                    ->WhereNotNull('aju_app_keu_status')
                    ->WhereNull('aju_app_dir_status');
            });

        if ($statusApprove === 'disetujui') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_dir_status', '=', 'disetujui');
            });
        } elseif ($statusApprove === 'ditolak') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_dir_status', '=', 'ditolak');
            });
        }

        $dataPengajuan = $dataPengajuan->get();
        return new ApprovalPengajuanResource(true, 'List Data Pengajuan', $dataPengajuan);
    }

    public function approveVerifikasi(Request $request, $ajuId)
    {
        $validator = Validator::make($request->all(), [
            'usr_id' => 'required',
            'app_auth_user' => 'required',
            'app_auth_password' => 'required',
            'status_approve' => 'required',
            'keterangan' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $pengajuan = Pengajuan::findOrFail($ajuId);
        $nominalPengajuan = $pengajuan->aju_nominal;

        $usrid = $request->input('usr_id');
        $appauthuser = $request->input('app_auth_user');
        $appauthpassword = $request->input('app_auth_password');
        $approveStatus = $request->input('status_approve');
        $approveKeterangan = $request->input('keterangan');

        $pejabatApp = PejabatApproval::where(['usr_id' => $usrid, 'app_auth_user' => $appauthuser])
            ->with(['jenisApproval' => function ($query) {
                $query->where('app_jenis', 'app_verifikasi');
            }])
            ->first();


        if ($pejabatApp->jenisApproval && $pejabatApp->app_auth_password === $appauthpassword) {
            $jenisApproval = JenisApproval::where('app_jenis', 'app_verifikasi')
                ->where('app_min_nom', '<=', $nominalPengajuan)
                ->orderBy('app_max_nom', 'desc')
                ->first();

            if ($jenisApproval) {
                $approval = ApprovalPengajuan::where('aju_id', $ajuId)
                    ->firstOrNew(['aju_id' => $ajuId]);

                if ($approval->aju_app_ver_status == 'disetujui' || $approval->aju_app_ver_status == 'ditolak') {
                    return new ApprovalPengajuanResource(false, 'Pengajuan sudah disetujui atau ditolak sebelumnya', $approval);
                }

                $approval->aju_id = $ajuId;
                $approval->aju_app_ver_tanggal = Carbon::now();
                $approval->aju_app_ver_jbt_id = $pejabatApp->pjbt_id;
                $approval->aju_app_ver_status = $approveStatus;
                $approval->aju_app_ver_keterangan = $approveKeterangan;
                $approval->save();

                if ($nominalPengajuan > $jenisApproval->app_max_nom) {
                    return new ApprovalPengajuanResource(true, 'Approval verifikasi berhasil, persetujuan dari Keuangan diperlukan', $approval);
                } else {
                    $approval->is_complete = "selesai";
                    $approval->save();

                    return new ApprovalPengajuanResource(true, 'Approval Selesai', $approval);
                }
            }
        } else {
            return new ApprovalPengajuanResource(false, 'User atau password Approval tidak Sesuai', $pejabatApp);
        }

        return new ApprovalPengajuanResource(false, 'Tidak ada jenis approval Verifikasi yang sesuai', $pengajuan);
    }

    public function approveKeuangan(Request $request, $ajuId)
    {
        $validator = Validator::make($request->all(), [
            'usr_id' => 'required',
            'app_auth_user' => 'required',
            'app_auth_password' => 'required',
            'status_approve' => 'required',
            'keterangan' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $pengajuan = Pengajuan::findOrFail($ajuId);
        $nominalPengajuan = $pengajuan->aju_nominal;

        $usrid = $request->input('usr_id');
        $appauthuser = $request->input('app_auth_user');
        $appauthpassword = $request->input('app_auth_password');
        $approveStatus = $request->input('status_approve');
        $approveKeterangan = $request->input('keterangan');

        $pejabatApp = PejabatApproval::where(['usr_id' => $usrid, 'app_auth_user' => $appauthuser])
            ->with(['jenisApproval' => function ($query) {
                $query->where('app_jenis', 'app_keuangan');
            }])
            ->first();

        if ($pejabatApp->jenisApproval && $pejabatApp->app_auth_password === $appauthpassword) {
            $jenisApproval = JenisApproval::where('app_jenis', 'app_keuangan')
                ->where('app_min_nom', '<=', $nominalPengajuan)
                ->orderBy('app_max_nom', 'desc')
                ->first();

            if ($jenisApproval) {
                $approval = ApprovalPengajuan::where('aju_id', $ajuId)
                    ->firstOrNew(['aju_id' => $ajuId]);

                if ($approval->aju_app_ver_status === 'disetujui' || $approval->aju_app_ver_status === 'ditolak') {
                    return new ApprovalPengajuanResource(false, 'Pengajuan sudah disetujui atau ditolak sebelumnya', $approval);
                }

                $approval->aju_id = $ajuId;
                $approval->aju_app_keu_tanggal = Carbon::now();
                $approval->aju_app_keu_jbt_id = $pejabatApp->pjbt_id;
                $approval->aju_app_keu_status = $approveStatus;
                $approval->aju_app_keu_keterangan = $approveKeterangan;
                $approval->save();

                if ($nominalPengajuan > $jenisApproval->app_max_nom) {
                    return new ApprovalPengajuanResource(true, 'Approval Keuangan berhasil, persetujuan dari Direksi diperlukan', $approval);
                } else {
                    $approval->is_complete = "selesai";
                    $approval->save();

                    return new ApprovalPengajuanResource(true, 'Approval Selesai', $approval);
                }
            }
        } else {
            return new ApprovalPengajuanResource(false, 'User atau password Approval tidak Sesuai', $pejabatApp);
        }
        return new ApprovalPengajuanResource(false, 'Tidak ada jenis approval Keuangan yang sesuai', $pengajuan);
    }

    public function approveDireksi(Request $request, $ajuId)
    {
        $validator = Validator::make($request->all(), [
            'usr_id' => 'required',
            'app_auth_user' => 'required',
            'app_auth_password' => 'required',
            'status_approve' => 'required',
            'keterangan' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $pengajuan = Pengajuan::findOrFail($ajuId);
        $nominalPengajuan = $pengajuan->aju_nominal;

        $usrid = $request->input('usr_id');
        $appauthuser = $request->input('app_auth_user');
        $appauthpassword = $request->input('app_auth_password');
        $approveStatus = $request->input('status_approve');
        $approveKeterangan = $request->input('keterangan');

        $pejabatApp = PejabatApproval::where(['usr_id' => $usrid, 'app_auth_user' => $appauthuser])
            ->with(['jenisApproval' => function ($query) {
                $query->where('app_jenis', 'app_direksi');
            }])
            ->first();

        if ($pejabatApp->jenisApproval && $pejabatApp->app_auth_password === $appauthpassword) {
            $jenisApproval = JenisApproval::where('app_jenis', 'app_direksi')
                ->where('app_min_nom', '<=', $nominalPengajuan)
                ->orderBy('app_max_nom', 'desc')
                ->first();

            if ($jenisApproval) {
                $approval = ApprovalPengajuan::where('aju_id', $ajuId)
                    ->firstOrNew(['aju_id' => $ajuId]);

                if ($approval->aju_app_ver_status === 'disetujui' || $approval->aju_app_ver_status === 'ditolak') {
                    return new ApprovalPengajuanResource(false, 'Pengajuan sudah disetujui atau ditolak sebelumnya', $approval);
                }

                $approval->aju_id = $ajuId;
                $approval->aju_app_keu_tanggal = Carbon::now();
                $approval->aju_app_keu_jbt_id = $pejabatApp->pjbt_id;
                $approval->aju_app_keu_status = $approveStatus;
                $approval->aju_app_keu_keterangan = $approveKeterangan;
                $approval->is_complete = "selesai";
                $approval->save();

                return new ApprovalPengajuanResource(true, 'Approval Selesai', $approval);
            }
        } else {
            return new ApprovalPengajuanResource(false, 'User atau password Approval tidak Sesuai', $pejabatApp);
        }
        return new ApprovalPengajuanResource(false, 'Tidak ada jenis approval Keuangan yang sesuai', $pengajuan);
    }
}
