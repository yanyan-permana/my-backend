<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\JenisApproval;
use App\Models\PejabatApproval;
use App\Models\User;
use Illuminate\Http\Request;

class PejabatApprovalController extends Controller
{
    public function index()
    {
        $pejabatApproval = PejabatApproval::with(['jenisApproval', 'user'])
            ->get()
            ->map(function ($pejabatApproval) {
                return [
                    'pjbt_id' => $pejabatApproval->pjbt_id,
                    'app_id' => $pejabatApproval->app_id,
                    'usr_id' => $pejabatApproval->usr_id,
                    'app_auth_user' => $pejabatApproval->app_auth_user,
                    'app_auth_password' => $pejabatApproval->app_auth_password,
                    'pjbt_status' => $pejabatApproval->pjbt_status,
                    'app_nama' => $pejabatApproval->jenisApproval->app_nama,
                    'usr_login' => $pejabatApproval->user->usr_login,
                ];
            });
        
        return view('pejabatapproval.index', compact('pejabatApproval'));
    }

    public function create()
    {
        $jenisApproval = JenisApproval::all();
        $user = User::all();

        return view('pejabatapproval.create', compact('jenisApproval', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'app_id' => 'required',
            'usr_id' => 'required',
            'app_auth_user' => 'required',
            'app_auth_password' => 'required',
            'pjbt_status' => 'required',
        ]);
        
        PejabatApproval::create([
            'app_id' => $request->app_id,
            'usr_id' => $request->usr_id,
            'app_auth_user' => $request->app_auth_user,
            'app_auth_password' => $request->app_auth_password,
            'pjbt_status' => $request->pjbt_status,
        ]);
        
        return redirect('/pejabat-approval')->with('success', 'Data Pejabat Approval Berhasil Ditambahkan!');
    }

    public function edit(PejabatApproval $pejabatApproval)
    {
        $jenisApproval = JenisApproval::all();
        $user = User::all();

        return view('pejabatapproval.edit', compact('pejabatApproval', 'jenisApproval', 'user'));
    }

    public function update(Request $request, PejabatApproval $pejabatApproval)
    {
        // validasi
        $request->validate([
            'app_id' => 'required',
            'usr_id' => 'required',
            'app_auth_user' => 'required',
            'app_auth_password' => 'required',
            'pjbt_status' => 'required',
        ]);

        $pejabatApproval->update([
            'app_id' => $request->app_id,
            'usr_id' => $request->usr_id,
            'app_auth_user' => $request->app_auth_user,
            'app_auth_password' => $request->app_auth_password,
            'pjbt_status' => $request->pjbt_status,
        ]);

        return redirect('/pejabat-approval')->with('success', 'Data Pejabat Approval Berhasil Diubah!');
    }

    public function destroy($id)
    {
        $pejabatApproval = PejabatApproval::where('pjbt_id', $id)->first();
        if ($pejabatApproval) {
            $pejabatApproval->delete();
            return redirect('/pejabat-approval')->with('success', 'Data Pejabat Approval Berhasil Dihapus!');
        } else {
            return redirect('/pejabat-approval')->with('error', 'Data Pejabat Approval Tidak Ditemukan!');
        }
    }
}
