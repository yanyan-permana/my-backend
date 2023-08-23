<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 't_pengajuan';
    protected $primaryKey = 'aju_id';
    protected $fillable = [
        'kry_id',
        'trx_id',
        'aju_nomor',
        'aju_tanggal',
        'aju_nominal',
        'aju_keterangan',
    ];

    public function jenisTransaksi()
    {
        return $this->belongsTo(JenisTransaksi::class, 'trx_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'kry_id');
    }

    public static function generateAJUNumber()
    {
        $latestNumber = static::select('aju_nomor')
            ->orderByRaw('CONVERT(SUBSTRING_INDEX(aju_nomor, "AJU", -1), UNSIGNED) DESC')
            ->first();
        if ($latestNumber) {
            $latestNumber = intval(substr($latestNumber->aju_nomor, 3));
            $number = $latestNumber + 1;
        } else {
            $number = 1;
        }

        $tplNumber = 'AJU' . $number;

        return $tplNumber;
    }

    public function approval()
    {
        return $this->hasOne(ApprovalPengajuan::class, 'aju_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'kry_id');
    }
}
