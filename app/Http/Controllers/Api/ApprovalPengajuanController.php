<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApprovalPengajuanResource;
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
                $query->where('aju_app_ver_status', '=', 'Approve');
            });
        } elseif ($statusApprove === 'disapprove') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_ver_status', '=', 'Disapprove');
            });
        }

        $dataPengajuan = $dataPengajuan->get();
        return new ApprovalPengajuanResource(true, 'List Data Pengajuan', $dataPengajuan);
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
                $query->where('aju_app_keu_status', '=', 'Approve');
            });
        } elseif ($statusApprove === 'disapprove') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_keu_status', '=', 'Disapprove');
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
                $query->where('aju_app_dir_status', '=', 'Approve');
            });
        } elseif ($statusApprove === 'disapprove') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_dir_status', '=', 'Disapprove');
            });
        }

        $dataPengajuan = $dataPengajuan->get();
        return new ApprovalPengajuanResource(true, 'List Data Pengajuan', $dataPengajuan);
    }
}
