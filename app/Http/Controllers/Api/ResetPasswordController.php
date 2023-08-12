<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResetPasswordResource;
use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function index(Request $request)
    {
        $email = $request->email;

        $otp = mt_rand(100000, 999999);

        $mailData = [
            'title' => 'Reset Password',
            'body' => 'Kode OTP ' . $otp,
        ];

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $otp,
            'created_at' => Carbon::now()
        ]);

        Mail::to($email)->send(new SendMail($mailData));

        return new ResetPasswordResource(true, 'Kode OTP telah dikirimkan ke email', null);
    }

    public function checkOtp(Request $request)
    {
        $email = $request->email;
        $otp = $request->otp;

        $resetData = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $otp)
            ->first();

        if (!$resetData) {
            return new ResetPasswordResource(false, 'Kode OTP tidak valid!', null);
        }

        return new ResetPasswordResource(true, 'Kode OTP valid', null);
    }

    public function resetPassword(Request $request)
    {
        User::where('usr_email', $request->email)
            ->update(['usr_password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return new ResetPasswordResource(true, 'Password berhasil diubah!', null);
    }
}
