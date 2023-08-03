<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BuktiTransaksiResource;
use App\Models\BuktiTransaksi;
use Illuminate\Http\Request;

class BuktiTransaksiController extends Controller
{
    public function destroy($id)
    {
        $bukti = BuktiTransaksi::where('bkt_id', $id)->first();
        if ($bukti) {
            $bukti->delete();
            return new BuktiTransaksiResource(true, 'Bukti Transaksi Berhasil Dihapus!', null);
        } else {
            return new BuktiTransaksiResource(false, 'Bukti Transaksi Tidak Ditemukan!', null);
        }
    }
}
