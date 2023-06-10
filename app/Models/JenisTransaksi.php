<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTransaksi extends Model
{
    use HasFactory;

    protected $table = 'm_jenis_transaksi';
    protected $primaryKey = 'trx_id';
    protected $fillable = [
        'trx_nama',
        'trx_kategori',
    ];
}
