<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->with('karyawan')
            ->get();
        $user = [];

        foreach ($users as $row) {
            $user[] = [
                'usr_id' => $row->usr_id,
                'kry_id' => $row->karyawan->kry_id,
                'usr_login' => $row->usr_login,
                'usr_email' => $row->usr_email,
                'usr_hak_akses' => $row->usr_hak_akses,
                'usr_password' => $row->usr_password,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
                'kry_nama' => $row->karyawan->kry_nama,
                'kry_jabatan' => $row->karyawan->kry_jabatan,
            ];
        }

        return view('users.index', compact('user'));
    }

    public function create()
    {
        $karyawan = Karyawan::all();
        return view('users.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kry_id' => 'required',
            'usr_login' => 'required|unique:m_user',
            'usr_email' => 'required',
            'usr_hak_akses' => 'required',
            'usr_password' => 'required',
        ]);
        
        User::create([
            'kry_id' => $request->kry_id,
            'usr_login' => $request->usr_login,
            'usr_email' => $request->usr_email,
            'usr_hak_akses' => $request->usr_hak_akses,
            'usr_password' => Hash::make($request->usr_password),
        ]);

        return redirect('/user')->with('success', 'Data Pengguna Berhasil Ditambahkan!');
    }

    public function edit(User $user)
    {
        $karyawan = Karyawan::all();
        return view('users.edit', compact('user', 'karyawan'));
    }

    public function update(Request $request, User $user)
{
    if ($user->kry_nik === $request->kry_nik) {
        $request->validate([
            'kry_id' => 'required',
            'usr_login' => 'required',
            'usr_email' => 'required',
        ]);
    } else {
        $request->validate([
            'kry_id' => 'required',
            'usr_login' => 'required|unique:m_user',
            'usr_hak_akses' => 'required',
        ]);
    }

    $dataToUpdate = [
        'kry_id' => $request->kry_id,
        'usr_login' => $request->usr_login,
        'usr_email' => $request->usr_email,
        'usr_hak_akses' => $request->usr_hak_akses,
    ];

    if ($request->filled('usr_password')) {
        $dataToUpdate['usr_password'] = Hash::make($request->usr_password);
    }

    $user->update($dataToUpdate);

    return redirect('/user')->with('success', 'Data Pengguna Berhasil Diubah!');
}


    public function destroy($id)
    {
        $user = User::where('usr_id', $id)->first();
        if ($user) {
            $user->delete();
            return redirect('/user')->with('success', 'Data Pengguna Berhasil Dihapus!');
        } else {
            return redirect('/user')->with('error', 'Data Pengguna Tidak Ditemukan!');
        }
    }
}
