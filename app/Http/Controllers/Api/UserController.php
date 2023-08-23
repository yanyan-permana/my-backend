<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\PenerimaanLangsung;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->with('karyawan')
            ->get();
        $user = [];

        foreach ($users as $row) {
            $user[] = [
                'usr_id' => $row->usr_id,
                'kry_id' => $row->karyawan->kry_id,
                'usr_login' => $row->usr_login,
                'usr_email' => $row->usr_email,
                'usr_hak_akses' => $row->usr_hak_akses,
                'usr_password' => $row->usr_password,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
                'kry_nama' => $row->karyawan->kry_nama,
                'kry_jabatan' => $row->karyawan->kry_jabatan,
            ];
        }

        return new UserResource(true, 'List Data User', $user);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'kry_id' => 'required',
            'usr_login' => 'required|unique:m_user',
            'usr_email' => 'required',
            'usr_hak_akses' => 'required',
            'usr_password' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // input user
        $user = User::create([
            'kry_id' => $request->kry_id,
            'usr_login' => $request->usr_login,
            'usr_email' => $request->usr_email,
            'usr_hak_akses' => $request->usr_hak_akses,
            'usr_password' => Hash::make($request->usr_password),
        ]);
        return new UserResource(true, 'Data User Berhasil Ditambahkan!', $user);
    }

    public function show($id)
    {
        $user = User::where('usr_id', $id)->with('karyawan')->first();
        if ($user) {
            return new UserResource(true, 'Data User Ditemukan!', $user);
        } else {
            return new UserResource(false, 'Data User Tidak Ditemukan!', null);
        }
    }

    public function update(Request $request, User $user)
    {
        // validasi
        if ($user->kry_nik === $request->kry_nik) {
            $validator = Validator::make($request->all(), [
                'kry_id' => 'required',
                'usr_login' => 'required',
                'usr_email' => 'required',
                'usr_password' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'kry_id' => 'required',
                'usr_login' => 'required|unique:m_user',
                'usr_hak_akses' => 'required',
                'usr_password' => 'required',
            ]);
        }
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user->update([
            'kry_id' => $request->kry_id,
            'usr_login' => $request->usr_login,
            'usr_email' => $request->usr_email,
            'usr_hak_akses' => $request->usr_hak_akses,
            'usr_password' => Hash::make($request->usr_password),
        ]);
        return new UserResource(true, 'Data User Berhasil Diubah!', $user);
    }

    public function destroy($id)
    {
        $user = User::where('usr_id', $id)->first();
        if ($user) {
            $isUsedPengajuan = Pengajuan::where('kry_id', $user->kry_id)->exists();
            $isUsedPenerimaan = PenerimaanLangsung::where('usr_id', $id)->exists();
            if ($isUsedPengajuan || $isUsedPenerimaan) {
                return new UserResource(false, 'Data User Tidak bisa dihapus karena sudah terdaftar pada transaksi!', null);
            } else {
                $user->delete();
                return new UserResource(true, 'Data User Berhasil Dihapus!', null);
            }
        } else {
            return new UserResource(false, 'Data User Tidak Ditemukan!', null);
        }
    }
}
