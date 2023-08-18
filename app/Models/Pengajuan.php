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
        $latestNumber = static::max('aju_nomor');

        if ($latestNumber) {
            // Ambil angka dari nomor urut terakhir
            $number = intval(substr($latestNumber, 3)) + 1;
        } else {
            // Jika tidak ada nomor urut sebelumnya, mulai dari 1
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
