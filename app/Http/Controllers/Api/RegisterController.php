<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'kry_nik' => 'required|unique:m_karyawan',
            'kry_nama' => 'required',
            'kry_bagian' => 'required',
            'kry_jabatan' => 'required',
            'usr_login' => 'required|unique:m_user',
            'usr_password' => 'required|min:8|confirmed',
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // input ke table m_karyawan
        $karyawan = Karyawan::create([
            'kry_nik' => $request->kry_nik,
            'kry_nama' => $request->kry_nama,
            'kry_bagian' => $request->kry_bagian,
            'kry_jabatan' => $request->kry_jabatan,
        ]);
        // input ke table m_user
        $user = User::create([
            'kry_id' => $karyawan->kry_id,
            'usr_login' => $request->usr_login,
            'usr_password' => Hash::make($request->usr_password)
        ]);
        if($user) {
            return response()->json([
                'success' => true,
                'data' => array_merge($karyawan->toArray(), $user->toArray()),
            ], 201);
        }
        return response()->json([
            'success' => false,
        ], 409);
    }
}