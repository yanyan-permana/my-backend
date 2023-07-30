<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanggungJawaban extends Model
{
    use HasFactory;
    protected $table = 't_pertanggung_jawaban';
    protected $primaryKey = 'tgjwb_id';
    protected $fillable = [
        'real_id',
        'trans_jns',
        'tgjwb_nomor',
        'tgjwb_tanggal',
        'tgjwb_nominal',
        'tgjwb_keterangan',
    ];

    public static function generatePjNumber()
    {
        $latestNumber = static::max('tgjwb_nomor');

        if ($latestNumber) {
            // Ambil angka dari nomor urut terakhir
            $number = intval(substr($latestNumber, 3)) + 1;
        } else {
            // Jika tidak ada nomor urut sebelumnya, mulai dari 1
            $number = 1;
        }

        $tplNumber = 'PJWB' . $number;

        return $tplNumber;
    }

    public function realisasi()
    {
        return $this->hasOne(RealisasiPengajuan::class, 'real_id', 'real_id');
    }
}
