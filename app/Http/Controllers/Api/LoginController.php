<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LoginController extends Controller
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
            'usr_login' => 'required',
            'usr_password' => 'required'
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only('usr_login', 'usr_password');
        $credentials = [
            'usr_login' => $credentials['usr_login'],
            'password' => $credentials['usr_password'],
        ];
        // jika autentikasi gagal
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'User login atau User password Anda salah'
            ], 401);
        }

        // Tampilkan waktu sebulan mendatang untuk masa expired token
        $token_expired = Carbon::now()->addMonth()->format('Y-m-d');

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'user'    => auth()->guard('api')->user(),
            'token'   => $token,
            'token_expired' => $token_expired
        ], 200);
    }
}
