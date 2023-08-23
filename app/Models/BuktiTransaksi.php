<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BuktiTransaksi extends Model
{
    use HasFactory;
    protected $table = 't_bukti';
    protected $primaryKey = 'bkt_id';
    protected $fillable = [
        'trans_id',
        'trans_jns',
        'bkt_file_nama',
        'bkt_mime_tipe',
        'bkt_orig_nama',
        'bkt_file_ukuran',
        'bkt_file_folder',
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/public/uploads/' . $value),
        );
    }
}
