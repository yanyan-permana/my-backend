<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanLangsung extends Model
{
    use HasFactory;

    protected $table = 't_penerimaan_langsung';
    protected $primaryKey = 'tpl_id';
    protected $fillable = [
        'usr_id',
        'trans_jns',
        'tpl_nomor',
        'tpl_tanggal',
        'tpl_nominal',
        'tpl_keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usr_id');
    }

    public function jenisTransaksi()
    {
        return $this->belongsTo(JenisTransaksi::class, 'trans_jns');
    }

    public static function generateTplNumber()
    {
        $latestNumber = static::max('tpl_nomor');

        if ($latestNumber) {
            // Ambil angka dari nomor urut terakhir
            $number = intval(substr($latestNumber, 3)) + 1;
        } else {
            // Jika tidak ada nomor urut sebelumnya, mulai dari 1
            $number = 1;
        }

        $tplNumber = 'TPL' . $number;

        return $tplNumber;
    }
}
