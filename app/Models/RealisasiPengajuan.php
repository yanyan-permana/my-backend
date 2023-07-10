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
}
