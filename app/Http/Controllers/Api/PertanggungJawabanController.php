<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PertanggungJawabanResource;
use App\Models\BuktiTransaksi;
use App\Models\PertanggungJawaban;
use App\Models\RealisasiPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PertanggungJawabanController extends Controller
{
    public function index()
    {
        $pertanggungJawaban = PertanggungJawaban::with('realisasi', 'bukti')->get()
            ->map(function ($data) {
                return [
                    'real_id' => $data->real_id,
                    'tgjwb_id' => $data->tgjwb_id,
                    'tgjwb_keterangan' => $data->tgjwb_keterangan,
                    'tgjwb_nominal' => $data->tgjwb_nominal,
                    'tgjwb_nomor' => $data->tgjwb_nomor,
                    'tgjwb_tanggal' => $data->tgjwb_tanggal,
                    'trans_jns' => $data->trans_jns,
                    'real_nomor' => $data->realisasi ? $data->realisasi->real_nomor : null,
                    'real_nominal' => $data->realisasi ? $data->realisasi->real_nominal : null,
                    'bukti' => $data->bukti,
                ];
            });
        return new PertanggungJawabanResource(true, 'List Data Realisasi', $pertanggungJawaban);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'real_id' => 'required',
            'tgjwb_nomor' => 'required|unique:App\Models\PertanggungJawaban,tgjwb_nomor',
            'tgjwb_tanggal' => 'required',
            'tgjwb_nominal' => 'required',
            'tgjwb_keterangan' => 'string',
            'file.*' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048'
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pertanggungJawaban = PertanggungJawaban::create([
            'real_id' => $request->real_id,
            'trans_jns' => 'pengeluaran',
            'tgjwb_nomor' => $request->tgjwb_nomor,
            'tgjwb_tanggal' => $request->tgjwb_tanggal,
            'tgjwb_nominal' => $request->tgjwb_nominal,
            'tgjwb_keterangan' => $request->tgjwb_keterangan,
        ]);

        if ($request->hasFile('file')) {
            $uploadedFiles = $request->file('file');
            foreach ($uploadedFiles as $uploadedFile) {
                $filename = time() . '_' . $uploadedFile->getClientOriginalName();
                $filePath = $uploadedFile->storeAs('public/uploads', $filename);

                $fileData = [
                    'trans_id' => $pertanggungJawaban->tgjwb_id,
                    'trans_jns' => $pertanggungJawaban->trans_jns,
                    'bkt_file_nama' => $filename,
                    'bkt_mime_tipe' =>  $uploadedFile->getClientMimeType(),
                    'bkt_orig_nama' => $uploadedFile->getClientOriginalName(),
                    'bkt_file_ukuran' => $uploadedFile->getSize(),
                    'bkt_file_folder' => $filePath,
                ];

                $bukti = BuktiTransaksi::create($fileData);
            }
        }
        return new PertanggungJawabanResource(true, 'Data Realisasi Berhasil Ditambahkan!', ['pertanggung_jawaban' => $pertanggungJawaban, 'bukti' => $bukti]);
    }

    public function show($id)
    {
        $pertanggungJawaban = PertanggungJawaban::where('tgjwb_id', $id)->with('realisasi', 'bukti')->first();

        if ($pertanggungJawaban) {
            $pertanggungJawaban = [
                'real_id' => $pertanggungJawaban->real_id,
                'tgjwb_id' => $pertanggungJawaban->tgjwb_id,
                'tgjwb_keterangan' => $pertanggungJawaban->tgjwb_keterangan,
                'tgjwb_nominal' => $pertanggungJawaban->tgjwb_nominal,
                'tgjwb_nomor' => $pertanggungJawaban->tgjwb_nomor,
                'tgjwb_tanggal' => $pertanggungJawaban->tgjwb_tanggal,
                'trans_jns' => $pertanggungJawaban->trans_jns,
                'real_nomor' => $pertanggungJawaban->realisasi ? $pertanggungJawaban->realisasi->real_nomor : null,
                'real_nominal' => $pertanggungJawaban->realisasi ? $pertanggungJawaban->realisasi->real_nominal : null,
                'bukti' => $pertanggungJawaban->bukti,
            ];
            return new PertanggungJawabanResource(true, 'Data realisasi Ditemukan!', $pertanggungJawaban);
        } else {
            return new PertanggungJawabanResource(false, 'Data realisasi Tidak Ditemukan!', null);
        }
    }

    public function update(Request $request, $id)
    {
        $pertanggungJawaban = PertanggungJawaban::find($id);
        // validasi
        $validator = Validator::make($request->all(), [
            'real_id' => 'required',
            'trans_jns' => 'required',
            'tgjwb_nomor' => 'required|exists:App\Models\PertanggungJawaban,tgjwb_nomor',
            'tgjwb_tanggal' => 'required',
            'tgjwb_nominal' => 'required',
            'tgjwb_keterangan' => 'string',
            'file.*' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048'
        ]);
        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pertanggungJawaban->update([
            'real_id' => $request->real_id,
            'trans_jns' => $request->trans_jns,
            'tgjwb_nomor' => $request->tgjwb_nomor,
            'tgjwb_tanggal' => $request->tgjwb_tanggal,
            'tgjwb_nominal' => $request->tgjwb_nominal,
            'tgjwb_keterangan' => $request->tgjwb_keterangan,
        ]);

        $bukti = [];

        if ($request->hasFile('file')) {
            $uploadedFiles = $request->file('file');
            foreach ($uploadedFiles as $uploadedFile) {
                $filename = time() . '_' . $uploadedFile->getClientOriginalName();
                $filePath = $uploadedFile->storeAs('public/uploads', $filename);

                $fileData = [
                    'trans_id' => $pertanggungJawaban->tgjwb_id,
                    'trans_jns' => 'pengeluaran',
                    'bkt_file_nama' => $filename,
                    'bkt_mime_tipe' =>  $uploadedFile->getClientMimeType(),
                    'bkt_orig_nama' => $uploadedFile->getClientOriginalName(),
                    'bkt_file_ukuran' => $uploadedFile->getSize(),
                    'bkt_file_folder' => $filePath,
                ];

                $bukti = BuktiTransaksi::create($fileData);
            }
        }
        return new PertanggungJawabanResource(true, 'Data Realisasi Berhasil Diubah!', ['pertanggung_jawaban' => $pertanggungJawaban, 'bukti' => $bukti]);
    }

    public function destroy($id)
    {
        $pertanggungJawaban = PertanggungJawaban::where('tgjwb_id', $id)->first();
        if ($pertanggungJawaban) {
            $pertanggungJawaban->delete();
            $buktiFiles = BuktiTransaksi::where('trans_id', $pertanggungJawaban->tgjwb_id)->get();
            foreach ($buktiFiles as $file) {
                Storage::delete($file->bkt_file_folder);
            }
            BuktiTransaksi::where(['trans_id' => $pertanggungJawaban->tgjwb_id, 'trans_jns' => $pertanggungJawaban->trans_jns])->delete();
            return new PertanggungJawabanResource(true, 'Data Pengajuan Berhasil Dihapus!', null);
        } else {
            return new PertanggungJawabanResource(false, 'Data Pengajuan Tidak Ditemukan!', null);
        }
    }

    public function loadRealisasi()
    {
        $result = RealisasiPengajuan::has('pertanggungJawaban', '=', 0)->get();
        if ($result) {
            return new PertanggungJawabanResource(true, 'Pengajuan Ditemukan!', $result);
        } else {
            return new PertanggungJawabanResource(false, 'Pengajuan Tidak Ditemukan!', null);
        }
    }

    public function getNomor()
    {
        $result = PertanggungJawaban::generatePjNumber();
        if ($result) {
            return new PertanggungJawabanResource(true, 'Realisasi Nomor Ditemukan!', $result);
        } else {
            return new PertanggungJawabanResource(false, 'Realisasi Nomor Tidak Ditemukan!', null);
        }
    }
}
