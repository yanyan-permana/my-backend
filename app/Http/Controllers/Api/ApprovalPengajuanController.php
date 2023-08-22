<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApprovalPengajuanResource;
use App\Models\ApprovalPengajuan;
use App\Models\JenisApproval;
use App\Models\PejabatApproval;
use App\Models\Pengajuan;
use App\Traits\PushNotificationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApprovalPengajuanController extends Controller
{
    use PushNotificationTrait;
    public function getPengajuanById($ajuId)
    {
        $dataPengajuan = Pengajuan::where('aju_id', $ajuId)->with(['approval', 'jenisTransaksi', 'karyawan'])->first();
        if ($dataPengajuan) {
            return new ApprovalPengajuanResource(true, 'Data Pengajuan', $dataPengajuan);
        } else {
            return new ApprovalPengajuanResource(false, 'Pengajuan tidak ditemukan!', $dataPengajuan);
        }
    }

    public function getPengajuanVerifikasi(Request $request)
    {
        $statusApprove = $request->input('status_approve', '');

        $dataPengajuan = Pengajuan::with(['approval', 'jenisTransaksi', 'karyawan'])->orderBy('aju_id', 'desc');
        if ($statusApprove === '') {
            $dataPengajuan->whereDoesntHave('approval', function ($query) {
                $query->whereNotNull('aju_app_ver_status')
                    ->WhereNull('aju_app_keu_status')
                    ->WhereNull('aju_app_dir_status');
            })
                ->where(function ($query) {
                    $query->whereDoesntHave('approval', function ($subquery) {
                        $subquery->where('is_complete', 'ditolak')
                            ->orWhere('is_complete', 'selesai');
                    });
                })
                ->orWhere(function ($query) {
                    $query->whereDoesntHave('approval');
                });
        } elseif ($statusApprove === 'disetujui') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_ver_status', '=', 'disetujui');
            });
        } elseif ($statusApprove === 'ditolak') {
            $dataPengajuan->whereHas('approval', function ($query) {
                $query->where('aju_app_ver_status', '=', 'ditolak');
            });
        }

        $dataPengajuan = $dataPengajuan->get();
        if ($dataPengajuan->count() > 0) {
            return new ApprovalPengajuanResource(true, 'List Pengajuan', $dataPengajuan);
        } else {
            return new ApprovalPengajuanResource(false, 'Pengajuan tidak ditemukan!', $dataPengajuan);
        }
    }

    public function getPengajuanKeuangan(Request $request)
    {
        $statusApprove = $request->input('status_approve', '');

        $jenisApproval = JenisApproval::where('app_jenis', 'app_keuangan')->first();
        $minNom = $jenisApproval->app_min_nom;
        $dataPengajuan = Pengajuan::with(['approval', 'jenisTransaksi', 'karyawan'])
            ->has('approval')
            ->where('aju_nominal', '>=', $minNom)
            ->whereHas('approval', function ($query) {
                $query->whereNotNull('aju_app_ver_status')
                    ->whereNull('aju_app_keu_status');
            })
            ->whereDoesntHave('approval', function ($query) {
                $query->where('is_complete', 'ditolak')
                    ->orWhere('is_complete', 'selesai');
            })
            ->orderBy('aju_id', 'desc');
        // ->orWhere(function ($query) {
        //     $query->whereDoesntHave('approval');
        // });
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
        if ($dataPengajuan->count() > 0) {
            return new ApprovalPengajuanResource(true, 'List Pengajuan', $dataPengajuan);
        } else {
            return new ApprovalPengajuanResource(false, 'Pengajuan tidak ditemukan!', $dataPengajuan);
        }
    }

    public function getPengajuanDireksi(Request $request)
    {
        $statusApprove = $request->input('status_approve', '');

        $jenisApproval = JenisApproval::where('app_jenis', 'app_direksi')->first();
        $minNom = $jenisApproval->app_min_nom;

        $dataPengajuan = Pengajuan::with(['approval', 'jenisTransaksi', 'karyawan'])
            ->has('approval')
            ->where('aju_nominal', '>=', $minNom)
            ->whereHas('approval', function ($query) {
                $query->whereNotNull('aju_app_ver_status')
                    ->whereNotNull('aju_app_keu_status')
                    ->whereNull('aju_app_dir_status');
            })
            ->whereDoesntHave('approval', function ($query) {
                $query->where('is_complete', 'ditolak')
                    ->orWhere('is_complete', 'selesai');
            })
            ->orderBy('aju_id', 'desc');
        // ->orWhere(function ($query) {
        //     $query->whereDoesntHave('approval');
        // });
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

        if ($dataPengajuan->count() > 0) {
            return new ApprovalPengajuanResource(true, 'List Pengajuan', $dataPengajuan);
        } else {
            return new ApprovalPengajuanResource(false, 'Pengajuan tidak ditemukan!', $dataPengajuan);
        }
    }

    public function approveVerifikasi(Request $request, $ajuId)
    {
        $validator = Validator::make($request->all(), [
            'usr_id' => 'required',
            'app_auth_user' => 'required',
            'app_auth_password' => 'required',
            'status_approve' => 'required',
            'keterangan' => 'nullable',
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
        $approveKeterangan = $request->input('keterangan', '');

        $pejabatApp = PejabatApproval::where(['usr_id' => $usrid, 'app_auth_user' => $appauthuser, 'pjbt_status' => 1])
            ->with(['jenisApproval' => function ($query) {
                $query->where('app_jenis', 'app_verifikasi');
            }])
            ->first();

        if ($pejabatApp && $pejabatApp->app_auth_password === $appauthpassword) {
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
                $approveStatus === 'ditolak' && $approval->is_complete = 'ditolak';
                $approval->save();
                if ($approveStatus === 'ditolak') {
                    $customData = [
                        'targetScreen' => 'HistoryPengajuanDrawer',
                        'hak_akses' => 'keuangan',
                    ];
                    $this->sendPushNotificationKaryawan($pengajuan->kry_id, "Pengajuan", "Pengajuan nomor $pengajuan->aju_nomor ditolak verifikasi, $approveKeterangan", $customData);
                    return new ApprovalPengajuanResource(true, 'Approval verifikasi ditolak', $approval);
                }
                if ($nominalPengajuan > $jenisApproval->app_max_nom) {
                    $customData = [
                        'targetScreen' => 'ApprovalKeuanganDrawer',
                        'hak_akses' => 'keuangan',
                    ];
                    $this->sendPushNotificationKeuangan("Pengajuan", "Pengajuan nomor $pengajuan->aju_nomor Telah di setujui oleh verifikasi dan menunggu approve oleh keuangan", $customData);
                    return new ApprovalPengajuanResource(true, 'Approval verifikasi berhasil, persetujuan dari Keuangan diperlukan', $approval);
                } else {
                    if ($approveStatus === 'disetujui') {
                        $customData = [
                            'targetScreen' => 'HistoryPengajuanDrawer',
                            'hak_akses' => 'keuangan',
                        ];
                        $this->sendPushNotificationKaryawan($pengajuan->kry_id, "Pengajuan", "Pengajuan nomor $pengajuan->aju_nomor disetujui verifikasi, tunggu realisasi dari keuangan", $customData);
                    }
                    $approval->is_complete = $approveStatus === 'disetujui' ? "selesai" : "ditolak";
                    $approval->save();

                    return new ApprovalPengajuanResource(true, 'Approval Selesai', $approval);
                }
            }
        } else {
            return new ApprovalPengajuanResource(false, 'User atau password Approval tidak Sesuai / Tidak Aktif', $pejabatApp);
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
            'keterangan' => 'nullable',
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
        $approveKeterangan = $request->input('keterangan', '');

        $pejabatApp = PejabatApproval::where(['usr_id' => $usrid, 'app_auth_user' => $appauthuser, 'pjbt_status' => 1])
            ->with(['jenisApproval' => function ($query) {
                $query->where('app_jenis', 'app_keuangan');
            }])
            ->first();

        if ($pejabatApp && $pejabatApp->app_auth_password === $appauthpassword) {
            $jenisApproval = JenisApproval::where('app_jenis', 'app_keuangan')
                ->where('app_min_nom', '<=', $nominalPengajuan)
                ->orderBy('app_max_nom', 'desc')
                ->first();

            if ($jenisApproval) {
                $approval = ApprovalPengajuan::where('aju_id', $ajuId)
                    ->whereNotNull('aju_app_ver_status')
                    ->firstOrNew(['aju_id' => $ajuId]);

                if ($approval->aju_app_ver_status === null) {
                    return new ApprovalPengajuanResource(false, 'Pengajuan belum di setujui oleh verifikasi', $approval);
                }

                if ($approval->aju_app_keu_status === 'disetujui' || $approval->aju_app_keu_status === 'ditolak') {
                    return new ApprovalPengajuanResource(false, 'Pengajuan sudah disetujui atau ditolak sebelumnya', $approval);
                }

                $approval->aju_id = $ajuId;
                $approval->aju_app_keu_tanggal = Carbon::now();
                $approval->aju_app_keu_jbt_id = $pejabatApp->pjbt_id;
                $approval->aju_app_keu_status = $approveStatus;
                $approval->aju_app_keu_keterangan = $approveKeterangan;
                $approveStatus === 'ditolak' && $approval->is_complete = 'ditolak';
                $approval->save();

                if ($approveStatus === 'ditolak') {
                    $customData = [
                        'targetScreen' => 'HistoryPengajuanDrawer',
                        'hak_akses' => 'direksi',
                    ];
                    $this->sendPushNotificationKaryawan($pengajuan->kry_id, "Pengajuan", "Pengajuan nomor $pengajuan->aju_nomor ditolak keuangan, $approveKeterangan", $customData);
                    return new ApprovalPengajuanResource(true, 'Approval Keuangan ditolak', $approval);
                }

                if ($nominalPengajuan > $jenisApproval->app_max_nom) {
                    $customData = [
                        'targetScreen' => 'ApprovalDireksiDrawer',
                        'hak_akses' => 'direksi'
                    ];
                    $this->sendPushNotificationDireksi("Pengajuan", "Pengajuan nomor $pengajuan->aju_nomor Telah di setujui oleh keuangan dan menunggu approve oleh direksi", $customData);
                    return new ApprovalPengajuanResource(true, 'Approval Keuangan berhasil, persetujuan dari Direksi diperlukan', $approval);
                } else {
                    if ($approveStatus === 'disetujui') {
                        $customData = [
                            'targetScreen' => 'HistoryPengajuanDrawer',
                            'hak_akses' => 'direksi'
                        ];
                        $this->sendPushNotificationKaryawan($pengajuan->kry_id, "Pengajuan", "Pengajuan nomor $pengajuan->aju_nomor disetujui keuangan, tunggu realisasi dari keuangan", $customData);
                    }
                    $approval->is_complete = $approveStatus === 'disetujui' ? "selesai" : "ditolak";
                    $approval->save();

                    return new ApprovalPengajuanResource(true, 'Approval Selesai', $approval);
                }
            }
        } else {
            return new ApprovalPengajuanResource(false, 'User atau password Approval tidak Sesuai / Tidak Aktif', $pejabatApp);
        }
        return new ApprovalPengajuanResource(false, 'Tidak Perlu Approve Keuangan', $pengajuan);
    }

    public function approveDireksi(Request $request, $ajuId)
    {
        $validator = Validator::make($request->all(), [
            'usr_id' => 'required',
            'app_auth_user' => 'required',
            'app_auth_password' => 'required',
            'status_approve' => 'required',
            'keterangan' => 'nullable',
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
        $approveKeterangan = $request->input('keterangan', '');

        $pejabatApp = PejabatApproval::where(['usr_id' => $usrid, 'app_auth_user' => $appauthuser, 'pjbt_status' => 1])
            ->with(['jenisApproval' => function ($query) {
                $query->where('app_jenis', 'app_direksi');
            }])
            ->first();

        if ($pejabatApp && $pejabatApp->app_auth_password === $appauthpassword) {
            $jenisApproval = JenisApproval::where('app_jenis', 'app_direksi')
                ->where('app_min_nom', '<=', $nominalPengajuan)
                ->orderBy('app_max_nom', 'desc')
                ->first();

            if ($jenisApproval) {
                $approval = ApprovalPengajuan::where('aju_id', $ajuId)
                    ->whereNotNull('aju_app_ver_status')
                    ->whereNotNull('aju_app_keu_status')
                    ->firstOrNew(['aju_id' => $ajuId]);

                if ($approval->aju_app_ver_status === null && $approval->aju_app_keu_status === null) {
                    return new ApprovalPengajuanResource(false, 'Pengajuan belum di setujui oleh Keuangan', $approval);
                }

                if ($approval->aju_app_dir_status === 'disetujui' || $approval->aju_app_dir_status === 'ditolak') {
                    return new ApprovalPengajuanResource(false, 'Pengajuan sudah disetujui atau ditolak sebelumnya', $approval);
                }

                $approval->aju_id = $ajuId;
                $approval->aju_app_keu_tanggal = Carbon::now();
                $approval->aju_app_keu_jbt_id = $pejabatApp->pjbt_id;
                $approval->aju_app_keu_status = $approveStatus;
                $approval->aju_app_keu_keterangan = $approveKeterangan;
                $approval->is_complete = $approveStatus === 'disetujui' ? "selesai" : "ditolak";
                $approval->save();

                if ($approveStatus === 'ditolak') {
                    $customData = [
                        'targetScreen' => 'HistoryPengajuanDrawer',
                        'hak_akses' => 'karyawan'
                    ];
                    $this->sendPushNotificationKaryawan($pengajuan->kry_id, "Pengajuan", "Pengajuan nomor $pengajuan->aju_nomor ditolak direksi, $approveKeterangan", $customData);
                    return new ApprovalPengajuanResource(true, 'Approval Direksi ditolak', $approval);
                }

                if ($approveStatus === 'disetujui') {
                    $customData = [
                        'targetScreen' => 'HistoryPengajuanDrawer',
                        'hak_akses' => 'karyawan'
                    ];
                    $this->sendPushNotificationKaryawan($pengajuan->kry_id, "Pengajuan", "Pengajuan nomor $pengajuan->aju_nomor disetujui direksi, tunggu realisasi dari keuangan", $customData);
                }
                return new ApprovalPengajuanResource(true, 'Approval Selesai', $approval);
            }
        } else {
            return new ApprovalPengajuanResource(false, 'User atau password Approval tidak Sesuai / Tidak Aktif', $pejabatApp);
        }
        return new ApprovalPengajuanResource(false, 'Tidak Perlu Approve Direksi', $pengajuan);
    }
}
