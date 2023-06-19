<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'm_karyawan';
    protected $primaryKey = 'kry_id';
    protected $fillable = [
        'kry_nik',
        'kry_nama',
        'kry_bagian',
        'kry_jabatan',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'kry_id');
    }
}
