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
        $latestNumber = static::select('tgjwb_nomor')
            ->orderByRaw('CONVERT(SUBSTRING_INDEX(aju_nomor, "PJWB", -1), UNSIGNED) DESC')
            ->first();

        if ($latestNumber) {
            $latestNumber = intval(substr($latestNumber->tgjwb_nomor, 4));
            $number = $latestNumber + 1;
        } else {
            $number = 1;
        }

        $tplNumber = 'PJWB' . $number;

        return $tplNumber;
    }

    public function realisasi()
    {
        return $this->hasOne(RealisasiPengajuan::class, 'real_id', 'real_id');
    }
    public function bukti()
    {
        return $this->hasMany(BuktiTransaksi::class, 'trans_id', 'tgjwb_id')->where('trans_jns', 'pengeluaran');
    }
}
