<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RealisasiPengajuanResource;
use App\Models\ApprovalPengajuan;
use App\Models\PertanggungJawaban;
use App\Models\RealisasiPengajuan;
use App\Traits\PushNotificationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RealisasiPengajuanController extends Controller
{
    use PushNotificationTrait;
    public function index()
    {
        $realisasi = RealisasiPengajuan::with(['karyawan', 'approval.pengajuan.jenisTransaksi'])->get()
            ->map(function ($realisasi) {
                return [
                    'real_id' => $realisasi->real_id,
                    'aju_app_id' => $realisasi->aju_app_id,
                    'real_nomor' => $realisasi->real_nomor,
                    'real_tanggal' => $realisasi->real_tanggal,
                    'real_nominal' => $realisasi->real_nominal,
                    'real_keterangan' => $realisasi->real_keterangan,
                    'real_pjbt_id' => $realisasi->real_pjbt_id,
                    'aju_nomor' => $realisasi->approval->pengajuan->aju_nomor,
                    'aju_nominal' => $realisasi->approval->pengajuan->aju_nominal,
                    'kry_nama' => $realisasi->karyawan->kry_nama,
                    'trx_nama' => $realisasi->approval->pengajuan->jenisTransaksi->trx_nama,
                    'created_at' => $realisasi->created_at,
                    'updated_at' => $realisasi->updated_at,
                ];
            });
        return new RealisasiPengajuanResource(true, 'List Data Realisasi', $realisasi);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'aju_app_id' => 'required',
            'real_pjbt_id' => 'required',
            'real_nomor' => 'required|unique:App\Models\RealisasiPengajuan, real_nomor',
            'real_tanggal' => 'required',
            'real_nominal' => 'required',
            'real_keterangan' => 'nullable|string',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $realisasi = RealisasiPengajuan::create([
            'aju_app_id' => $request->aju_app_id,
            'real_pjbt_id' => $request->real_pjbt_id,
            'real_nomor' => $request->real_nomor,
            'real_tanggal' => $request->real_tanggal,
            'real_nominal' => $request->real_nominal,
            'real_keterangan' => $request->real_keterangan,
        ]);

        if ($realisasi) {
            $data = ApprovalPengajuan::where('aju_app_id', $realisasi->aju_app_id)->with('pengajuan')->first();

            $customData = [
                'targetScreen' => 'HistoryPengajuanDrawer',
                'hak_akses' => 'karyawan'
            ];
            $nomorPengajuan = $data->pengajuan->aju_nomor;
            $this->sendPushNotificationKaryawan($data->pengajuan->kry_id, "Realisasi", "Pengajuan nomor $nomorPengajuan  telah direalisasikan", $customData);
        }

        return new RealisasiPengajuanResource(true, 'Data Realisasi Berhasil Ditambahkan!', $realisasi);
    }

    public function show($id)
    {
        $realisasi = RealisasiPengajuan::where('real_id', $id)->with(['karyawan', 'approval.pengajuan.jenisTransaksi'])->first()
            ->map(function ($realisasi) {
                return [
                    'real_id' => $realisasi->real_id,
                    'aju_app_id' => $realisasi->aju_app_id,
                    'real_nomor' => $realisasi->real_nomor,
                    'real_tanggal' => $realisasi->real_tanggal,
                    'real_nominal' => $realisasi->real_nominal,
                    'real_keterangan' => $realisasi->real_keterangan,
                    'real_pjbt_id' => $realisasi->real_pjbt_id,
                    'aju_nomor' => $realisasi->approval->pengajuan->aju_nomor,
                    'aju_nominal' => $realisasi->approval->pengajuan->aju_nominal,
                    'kry_nama' => $realisasi->karyawan->kry_nama,
                    'trx_nama' => $realisasi->approval->pengajuan->jenisTransaksi->trx_nama,
                    'created_at' => $realisasi->created_at,
                    'updated_at' => $realisasi->updated_at,
                ];
            });
        if ($realisasi) {
            return new RealisasiPengajuanResource(true, 'Data realisasi Ditemukan!', $realisasi);
        } else {
            return new RealisasiPengajuanResource(false, 'Data realisasi Tidak Ditemukan!', null);
        }
    }

    public function update(Request $request, $id)
    {
        $realisasi = RealisasiPengajuan::find($id);
        // validasi
        $validator = Validator::make($request->all(), [
            'aju_app_id' => 'required',
            'real_pjbt_id' => 'required',
            'real_nomor' => 'required|unique:App\Models\RealisasiPengajuan, real_nomor',
            'real_tanggal' => 'required',
            'real_nominal' => 'required',
            'real_keterangan' => 'nullable|string',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cekdata = PertanggungJawaban::where("real_id", $id)->first();

        if ($cekdata) {
            return new RealisasiPengajuanResource(false, 'Data realisasi tidak bisa diubah karena sudah dilakukan pertanggung jawaban!', $realisasi);
        }

        $realisasi->update([
            'aju_app_id' => $request->aju_app_id,
            'real_pjbt_id' => $request->real_pjbt_id,
            'real_nomor' => $request->real_nomor,
            'real_tanggal' => $request->real_tanggal,
            'real_nominal' => $request->real_nominal,
            'real_keterangan' => $request->real_keterangan,
        ]);

        return new RealisasiPengajuanResource(true, 'Data Realisasi Berhasil Diubah!', $realisasi);
    }

    public function destroy($id)
    {
        $realisasi = RealisasiPengajuan::where('real_id', $id)->first();
        $cekdata = PertanggungJawaban::where("real_id", $id)->first();

        if ($cekdata) {
            return new RealisasiPengajuanResource(false, 'Data realisasi tidak bisa dihapus karena sudah dilakukan pertanggung jawaban!', $realisasi);
        }
        
        if ($realisasi) {
            if ($realisasi->pertanggungJawaban()->exists()) {
                return new RealisasiPengajuanResource(false, 'Tidak Dapat Dihapus Karena Sudah Terdaftar Pada Pertanggung Jawaban!', null);
            }

            $realisasi->delete();
            return new RealisasiPengajuanResource(true, 'Data Pengajuan Berhasil Dihapus!', null);
        } else {
            return new RealisasiPengajuanResource(false, 'Data Pengajuan Tidak Ditemukan!', null);
        }
    }


    public function loadPengajuan()
    {
        $result = ApprovalPengajuan::where('is_complete', 'selesai')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('t_realisasi_pengajuan')
                    ->whereRaw('t_realisasi_pengajuan.aju_app_id = t_approval_pengajuan.aju_app_id');
            })->with(['pengajuan', 'pengajuan.jenisTransaksi', 'pengajuan.karyawan'])->get();
        if ($result) {
            return new RealisasiPengajuanResource(true, 'Pengajuan Ditemukan!', $result);
        } else {
            return new RealisasiPengajuanResource(false, 'Pengajuan Tidak Ditemukan!', null);
        }
    }

    public function getNomor()
    {
        $result = RealisasiPengajuan::generateRealNumber();
        if ($result) {
            return new RealisasiPengajuanResource(true, 'Realisasi Nomor Ditemukan!', $result);
        } else {
            return new RealisasiPengajuanResource(false, 'Realisasi Nomor Tidak Ditemukan!', null);
        }
    }
}
