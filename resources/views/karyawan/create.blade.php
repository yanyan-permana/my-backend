@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Karyawan</h1>
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
                        <form action="/karyawan" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="kry_nik">NIK *</label>
                                <input type="text" class="form-control" name="kry_nik" id="kry_nik" value="{{ old('kry_nik') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="kry_nama">Nama *</label>
                                <input type="text" class="form-control" name="kry_nama" id="kry_nama" value="{{ old('kry_nama') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="kry_bagian">Bagian *</label>
                                <input type="text" class="form-control" name="kry_bagian" id="kry_bagian" value="{{ old('kry_bagian') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="kry_jabatan">Jabatan *</label>
                                <input type="text" class="form-control" name="kry_jabatan" id="kry_jabatan" value="{{ old('kry_jabatan') }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
