<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiPengajuan extends Model
{
    use HasFactory;
    protected $table = 't_realisasi_pengajuan';
    protected $primaryKey = 'real_id';
    protected $fillable = [
        'aju_app_id',
        'real_nomor',
        'real_tanggal',
        'real_nominal',
        'real_keterangan',
        'real_pjbt_id',
    ];

    public static function generateRealNumber()
    {
        $latestNumber = static::max('real_nomor');

        if ($latestNumber) {
            // Ambil angka dari nomor urut terakhir
            $number = intval(substr($latestNumber, 3)) + 1;
        } else {
            // Jika tidak ada nomor urut sebelumnya, mulai dari 1
            $number = 1;
        }

        $tplNumber = 'REAL' . $number;

        return $tplNumber;
    }

    public function pertanggungJawaban()
    {
        return $this->hasOne(PertanggungJawaban::class, 'real_id');
    }

    public function approval()
    {
        return $this->hasOne(ApprovalPengajuan::class, 'aju_app_id', 'aju_app_id');
    }
}
