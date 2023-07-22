@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Karyawan</h1>
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
                        <form action="/karyawan/{{ $karyawan->kry_id }}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="kry_nik">NIK *</label>
                                <input type="text" class="form-control" name="kry_nik" id="kry_nik"
                                    value="{{ $karyawan->kry_nik }}">
                            </div>
                            <div class="form-group">
                                <label for="kry_nama">Nama *</label>
                                <input type="text" class="form-control" name="kry_nama" id="kry_nama"
                                    value="{{ $karyawan->kry_nama }}">
                            </div>
                            <div class="form-group">
                                <label for="kry_bagian">Bagian *</label>
                                <input type="text" class="form-control" name="kry_bagian" id="kry_bagian"
                                    value="{{ $karyawan->kry_bagian }}">
                            </div>
                            <div class="form-group">
                                <label for="kry_jabatan">Jabatan *</label>
                                <input type="text" class="form-control" name="kry_jabatan" id="kry_jabatan"
                                    value="{{ $karyawan->kry_jabatan }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-id="{{ $karyawan->kry_id }}" id="btn-hapus"
                                data-target="#modal-hapus">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Data</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah Anda yakin ingin menghapus data ini?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <form method="post" id="form-hapus">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '#btn-hapus', function() {
            const id = $(this).data('id');

            $('#form-hapus').attr('action', '/karyawan/' + id);
        });
    </script>
@endsection
