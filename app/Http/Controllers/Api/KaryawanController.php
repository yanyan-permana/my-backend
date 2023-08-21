<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KaryawanResource;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::all();
        return new KaryawanResource(true, 'List Data Karyawan', $karyawan);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'kry_nik' => 'required|unique:m_karyawan',
            'kry_nama' => 'required',
            'kry_bagian' => 'required',
            'kry_jabatan' => 'required',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // input karyawan
        $karyawan = Karyawan::create([
            'kry_nik' => $request->kry_nik,
            'kry_nama' => $request->kry_nama,
            'kry_bagian' => $request->kry_bagian,
            'kry_jabatan' => $request->kry_jabatan,
        ]);
        return new KaryawanResource(true, 'Data Karyawan Berhasil Ditambahkan!', $karyawan);
    }

    public function show($id)
    {
        $karyawan = Karyawan::where('kry_id', $id)->first();
        if ($karyawan) {
            return new KaryawanResource(true, 'Data Karyawan Ditemukan!', $karyawan);
        } else {
            return new KaryawanResource(false, 'Data Karyawan Tidak Ditemukan!', null);
        }
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        // validasi
        // if ($karyawan->kry_nik === $request->kry_nik) {
        //     $validator = Validator::make($request->all(), [
        //         'kry_nik' => 'required',
        //         'kry_nama' => 'required',
        //         'kry_bagian' => 'required',
        //         'kry_jabatan' => 'required',
        //     ]);
        // } else {
            $validator = Validator::make($request->all(), [
                'kry_nik' => 'required|unique:App\Models\karyawan, kry_nik',
                'kry_nama' => 'required',
                'kry_bagian' => 'required',
                'kry_jabatan' => 'required',
            ]);
        // }
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $karyawan->update([
            'kry_nik' => $request->kry_nik,
            'kry_nama' => $request->kry_nama,
            'kry_bagian' => $request->kry_bagian,
            'kry_jabatan' => $request->kry_jabatan,
        ]);
        return new KaryawanResource(true, 'Data Karyawan Berhasil Diubah!', $karyawan);
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::where('kry_id', $id)->first();
        if ($karyawan) {
            $isUsed = User::where('kry_id', $id)->exists();
            if ($isUsed) {
                return new KaryawanResource(false, 'Karyawan tidak dapat dihapus karena telah digunakan oleh pengguna!', null);
            } else {
                $karyawan->delete();
                return new KaryawanResource(true, 'Data Karyawan Berhasil Dihapus!', null);
            }
        } else {
            return new KaryawanResource(false, 'Data Karyawan Tidak Ditemukan!', null);
        }
    }

    public function getTotalKaryawan()
    {
        $result = Karyawan::count();
        if ($result) {
            return new KaryawanResource(true, 'Total Karyawan!', null);
        } else {
            return new KaryawanResource(false, 'Tidak ada karyawan!', null);
        }
    }
}
