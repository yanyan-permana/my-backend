@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Jenis Approval</h1>
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
                        <form action="/jenis-approval/{{ $jenisApproval->app_id }}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="app_jenis">Jenis *</label>
                                <input type="text" class="form-control" name="app_jenis" id="app_jenis"
                                    value="{{ $jenisApproval->app_jenis }}" required>
                            </div>
                            <div class="form-group">
                                <label for="app_nama">Nama *</label>
                                <input type="text" class="form-control" name="app_nama" id="app_nama"
                                    value="{{ $jenisApproval->app_nama }}" required>
                            </div>
                            <div class="form-group">
                                <label for="app_min_nom">Minimal Nominal *</label>
                                <input type="number" class="form-control" name="app_min_nom" id="app_min_nom"
                                    value="{{ $jenisApproval->app_min_nom }}" required>
                            </div>
                            <div class="form-group">
                                <label for="app_max_nom">Maximal Nominal *</label>
                                <input type="number" class="form-control" name="app_max_nom" id="app_max_nom"
                                    value="{{ $jenisApproval->app_max_nom }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-id="{{ $jenisApproval->app_id }}" id="btn-hapus"
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

            $('#form-hapus').attr('action', '/jenis-approval/' + id);
        });
    </script>
@endsection
