<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::all();
        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        // validasi
        $request->validate([
            'kry_nik' => 'required|unique:m_karyawan',
            'kry_nama' => 'required',
            'kry_bagian' => 'required',
            'kry_jabatan' => 'required',
        ]);
        
        Karyawan::create([
            'kry_nik' => $request->kry_nik,
            'kry_nama' => $request->kry_nama,
            'kry_bagian' => $request->kry_bagian,
            'kry_jabatan' => $request->kry_jabatan,
        ]);
        
        return redirect('/karyawan')->with('success', 'Data Karyawan Berhasil Ditambahkan!');
    }

    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        if ($karyawan->kry_nik === $request->kry_nik) {
            $request->validate([
                'kry_nik' => 'required',
                'kry_nama' => 'required',
                'kry_bagian' => 'required',
                'kry_jabatan' => 'required',
            ]);
        } else {
            $request->validate([
                'kry_nik' => 'required|unique:m_karyawan',
                'kry_nama' => 'required',
                'kry_bagian' => 'required',
                'kry_jabatan' => 'required',
            ]);
        }
       
        $karyawan->update([
            'kry_nik' => $request->kry_nik,
            'kry_nama' => $request->kry_nama,
            'kry_bagian' => $request->kry_bagian,
            'kry_jabatan' => $request->kry_jabatan,
        ]);
        
        return redirect('/karyawan')->with('success', 'Data Karyawan Berhasil Diubah!');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::where('kry_id', $id)->first();

        if ($karyawan) {
            $karyawan->delete();
            return redirect('/karyawan')->with('success', 'Data Jenis Approval Berhasil Dihapus!');
        } else {
            return redirect('/karyawan')->with('error', 'Data Jenis Approval Tidak Ditemukan!');
        }
    }
}
