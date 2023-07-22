@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Pengeluaran</h1>
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
                        <form action="/jenis-transaksi-pengeluaran" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="trx_nama">Nama *</label>
                                <input type="text" class="form-control" name="trx_nama" id="trx_nama" value="{{ old('trx_nama') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Kategori *</label>
                                <input type="text" class="form-control" value="Pengeluaran" disabled>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
