<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PejabatApproval extends Model
{
    use HasFactory;

    protected $table = 'm_pejabat_approval';
    protected $primaryKey = 'pjbt_id';
    protected $fillable = [
        'app_id',
        'usr_id',
        'app_auth_user',
        'app_auth_password',
        'pjbt_status',
    ];

    public function jenisApproval()
    {
        return $this->belongsTo(JenisApproval::class, 'app_id');
    }
}
