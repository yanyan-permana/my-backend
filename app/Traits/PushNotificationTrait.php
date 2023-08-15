<?php

namespace App\Traits;

use App\Models\PejabatApproval;

trait PushNotificationTrait
{
    public function sendPushNotificationPengajuan($title, $body, $data = [])
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
}
