<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisApproval extends Model
{
    use HasFactory;

    protected $table = 'm_jenis_approval';
    protected $primaryKey = 'app_id';
    protected $fillable = [
        'app_jenis',
        'app_nama',
        'app_min_nom',
        'app_max_nom',
    ];
}
