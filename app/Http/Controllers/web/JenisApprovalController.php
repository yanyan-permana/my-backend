<?php

namespace App\Http\Controllers\web;

use App\Models\JenisApproval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisApprovalController extends Controller
{
    public function index()
    {
        $jenisApproval = JenisApproval::all();
        return view('jenisapproval.index', compact('jenisApproval'));
    }

    public function edit(JenisApproval $jenisApproval)
    {
        return view('jenisapproval.edit', compact('jenisApproval'));
    }

    public function update(Request $request, JenisApproval $jenisApproval)
    {
        $request->validate([
            // 'app_jenis' => 'required',
            // 'app_nama' => 'required',
            'app_min_nom' => 'required',
            'app_max_nom' => 'required',
        ]);

        $jenisApproval->update([
            // 'app_jenis' => $request->app_jenis,
            // 'app_nama' => $request->app_nama,
            'app_min_nom' => $request->app_min_nom,
            'app_max_nom' => $request->app_max_nom,
        ]);
        
        return redirect('/jenis-approval')->with('success', 'Data Jenis Approval Berhasil Diubah!');
    }
}
