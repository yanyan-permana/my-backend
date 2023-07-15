<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApprovalPengajuanResource;
use App\Models\ApprovalPengajuan;
use App\Models\JenisApproval;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class ApprovalPengajuanController extends Controller
{
    public function getPengajuanVerifikasi(Request $request)
    {
        $statusApprove = $request->input('status_approve');

        $dataPengajuan = Pengajuan::with('approval')
            ->whereDoesntHave('approval', function ($query) {
                $query->whereNull('aju_app_ver_status')
                    ->WhereNull('aju_app_keu_status')
                    ->WhereNull('aju_app_dir_status');
            });

        if ($statusApprove === 'approve') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_ver_status', '=', 'approve');
            });
        } elseif ($statusApprove === 'disapprove') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_ver_status', '=', 'disapprove');
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

        $dataPengajuan = Pengajuan::with('approval')
            ->whereDoesntHave('approval', function ($query) {
                $query->whereNotNull('aju_app_ver_status')
                    ->WhereNull('aju_app_keu_status')
                    ->WhereNull('aju_app_dir_status');
            });

        if ($statusApprove === 'approve') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_keu_status', '=', 'approve');
            });
        } elseif ($statusApprove === 'disapprove') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_keu_status', '=', 'disapprove');
            });
        }

        $dataPengajuan = $dataPengajuan->get();
        return new ApprovalPengajuanResource(true, 'List Data Pengajuan', $dataPengajuan);
    }

    public function getPengajuanDireksi(Request $request)
    {
        $statusApprove = $request->input('status_approve');

        $dataPengajuan = Pengajuan::with('approval')
            ->whereDoesntHave('approval', function ($query) {
                $query->whereNotNull('aju_app_ver_status')
                    ->WhereNotNull('aju_app_keu_status')
                    ->WhereNull('aju_app_dir_status');
            });

        if ($statusApprove === 'approve') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_dir_status', '=', 'approve');
            });
        } elseif ($statusApprove === 'disapprove') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_dir_status', '=', 'disapprove');
            });
        }

        $dataPengajuan = $dataPengajuan->get();
        return new ApprovalPengajuanResource(true, 'List Data Pengajuan', $dataPengajuan);
    }

    public function approveVerifikasi($ajuId)
    {
        $pengajuan = Pengajuan::findOrFail($ajuId);
        $nominalPengajuan = $pengajuan->aju_nominal;

        $jenisApprovalVerifikasi = JenisApproval::where('app_jenis', 'app_verifikasi')
            ->where('app_min_nom', '<=', $nominalPengajuan)
            ->orderBy('app_max_nom', 'desc')
            ->first();

        if ($jenisApprovalVerifikasi) {
            $approvalVerifikasi = ApprovalPengajuan::where('aju_id', $ajuId)
                ->where('aju_app_id', $jenisApprovalVerifikasi->app_id)
                ->firstOrNew(['aju_id' => $ajuId]);

            $approvalVerifikasi->aju_app_ver_status = 'disetujui';
            $approvalVerifikasi->aju_app_ver_keterangan = 'Approval verifikasi berhasil';
            $approvalVerifikasi->save();

            if ($nominalPengajuan > $jenisApprovalVerifikasi->app_max_nom) {
                return new ApprovalPengajuanResource(true, 'Approval verifikasi berhasil, persetujuan dari Keuangan diperlukan', $approvalVerifikasi);
            } else {
                $approvalVerifikasi->is_complete = "selesai";
                $approvalVerifikasi->save();

                return new ApprovalPengajuanResource(true, 'Approval Selesai', $approvalVerifikasi);
            }
        }
        return new ApprovalPengajuanResource(false, 'Tidak ada jenis approval Verifikasi yang sesuai', $pengajuan);
    }
}
