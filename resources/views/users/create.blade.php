@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Pengguna</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form action="/user" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="kry_id">Karyawan *</label>
                                <select name="kry_id" id="kry_id" class="form-control">
                                    @foreach ($karyawan as $kry)
                                        <option value="{{ $kry->kry_id }}"
                                            {{ old('kry_id') === $kry->kry_id ? 'selected' : '' }}>{{ $kry->kry_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr_login">Username *</label>
                                <input type="text" class="form-control" name="usr_login" id="usr_login"
                                    value="{{ old('usr_login') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="usr_email">Email *</label>
                                <input type="email" class="form-control" name="usr_email" id="usr_email"
                                    value="{{ old('usr_email') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="usr_hak_akses">Hak Akses *</label>
                                <select name="usr_hak_akses" id="usr_hak_akses" class="form-control">
                                    <option value="karyawan" {{ old('usr_hak_akses') === 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                                    <option value="administrator" {{ old('usr_hak_akses') === 'administrator' ? 'selected' : '' }}>Administrator</option>
                                    <option value="keuangan" {{ old('usr_hak_akses') === 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                                    <option value="dikreksi" {{ old('usr_hak_akses') === 'dikreksi' ? 'selected' : '' }}>Dikreksi</option>
                                    <option value="verifikasi" {{ old('usr_hak_akses') === 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr_password">Password *</label>
                                <input type="password" class="form-control" name="usr_password" id="usr_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
