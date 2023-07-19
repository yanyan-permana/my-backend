<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalPengajuan extends Model
{
    use HasFactory;
    protected $table = 't_approval_pengajuan';
    protected $primaryKey = 'aju_app_id';
    protected $fillable = [
        'aju_id',
        'aju_app_ver_jbt_id',
        'aju_app_ver_tanggal',
        'aju_app_ver_status',
        'aju_app_ver_keterangan',
        'aju_app_keu_jbt_id',
        'aju_app_keu_tanggal',
        'aju_app_keu_status',
        'aju_app_keu_keterangan',
        'aju_app_dir_jbt_id',
        'aju_app_dir_tanggal',
        'aju_app_dir_status',
        'aju_app_dir_keterangan',
        'is_complete',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'aju_id');
    }
}
