<?php

namespace App\Traits;

use App\Models\PejabatApproval;
use App\Models\User;

trait PushNotificationTrait
{
    public function sendPushNotificationVerifikasi($title, $body, $data = [])
    {
        $user = PejabatApproval::with(["jenisApproval", "user"])
            ->whereHas('jenisApproval', function ($query) {
                $query->where('app_jenis', 'app_verifikasi');
            })
            ->get();

        if ($user) {
            foreach ($user as $users) {
                $notificationData = [
                    'to' => $users->user->token,
                    'title' => $title,
                    'body' => $body,
                    'data' => $data,
                ];
                $ch = curl_init('https://exp.host/--/api/v2/push/send');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                ]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                curl_close($ch);
            }
        }
    }

    public function sendPushNotificationKeuangan($title, $body, $data = [])
    {
        $user = PejabatApproval::with(["jenisApproval", "user"])
            ->whereHas('jenisApproval', function ($query) {
                $query->where('app_jenis', 'app_keuangan');
            })
            ->get();

        if ($user) {
            foreach ($user as $users) {
                $notificationData = [
                    'to' => $users->user->token,
                    'title' => $title,
                    'body' => $body,
                    'data' => $data,
                ];
                $ch = curl_init('https://exp.host/--/api/v2/push/send');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                ]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                curl_close($ch);
            }
        }
    }

    public function sendPushNotificationDireksi($title, $body, $data = [])
    {
        $user = PejabatApproval::with(["jenisApproval", "user"])
            ->whereHas('jenisApproval', function ($query) {
                $query->where('app_jenis', 'app_Direksi');
            })
            ->get();

        if ($user) {
            foreach ($user as $users) {
                $notificationData = [
                    'to' => $users->user->token,
                    'title' => $title,
                    'body' => $body,
                    'data' => $data,
                ];
                $ch = curl_init('https://exp.host/--/api/v2/push/send');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                ]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                curl_close($ch);
            }
        }
    }

    public function sendPushNotificationKaryawan($kryId, $title, $body, $data = [])
    {
        $user = User::where("kry_id", $kryId)->first();

        if ($user) {
            $notificationData = [
                'to' => $user->token,
                'title' => $title,
                'body' => $body,
                'data' => $data,
            ];
            $ch = curl_init('https://exp.host/--/api/v2/push/send');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            curl_close($ch);
        }
    }
}
