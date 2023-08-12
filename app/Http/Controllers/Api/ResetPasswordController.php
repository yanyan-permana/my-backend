<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResetPasswordResource;
use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;

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
         
        Mail::to($email)->send(new SendMail($mailData));

        return new ResetPasswordResource(true, 'Kode OTP telah dikirimkan ke email', null);
    }
}
