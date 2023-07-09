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
}
