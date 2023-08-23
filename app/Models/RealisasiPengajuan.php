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
        $latestNumber = static::select('real_nomor')
            ->orderByRaw('CONVERT(SUBSTRING_INDEX(real_nomor, "REAL", -1), UNSIGNED) DESC')
            ->first();

        if ($latestNumber) {
            $latestNumber = intval(substr($latestNumber->real_nomor, 4));
            $number = $latestNumber + 1;
        } else {
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

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'kry_id', 'real_pjbt_id');
    }
}
