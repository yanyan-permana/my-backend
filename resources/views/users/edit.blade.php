@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Pengguna</h1>
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
                        <form action="/user/{{ $user->usr_id }}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="kry_id">Karyawan *</label>
                                <select name="kry_id" id="kry_id" class="form-control">
                                    @foreach ($karyawan as $kry)
                                        <option value="{{ $kry->kry_id }}"
                                            {{ $user->kry_id === $kry->kry_id ? 'selected' : '' }}>{{ $kry->kry_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr_login">Username *</label>
                                <input type="text" class="form-control" name="usr_login" id="usr_login"
                                    value="{{ $user->usr_login }}" required>
                            </div>
                            <div class="form-group">
                                <label for="usr_email">Email *</label>
                                <input type="email" class="form-control" name="usr_email" id="usr_email"
                                    value="{{ $user->usr_email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="usr_hak_akses">Hak Akses *</label>
                                <select name="usr_hak_akses" id="usr_hak_akses" class="form-control">
                                    <option value="karyawan" {{ $user->usr_hak_akses === 'karyawan' ? 'selected' : '' }}>
                                        Karyawan</option>
                                    <option value="administrator"
                                        {{ $user->usr_hak_akses === 'administrator' ? 'selected' : '' }}>Administrator
                                    </option>
                                    <option value="keuangan" {{ $user->usr_hak_akses === 'keuangan' ? 'selected' : '' }}>
                                        Keuangan</option>
                                    <option value="dikreksi" {{ $user->usr_hak_akses === 'dikreksi' ? 'selected' : '' }}>
                                        Dikreksi</option>
                                    <option value="verifikasi"
                                        {{ $user->usr_hak_akses === 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr_password">Password *</label>
                                <input type="password" class="form-control" name="usr_password" id="usr_password">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-id="{{ $user->usr_id }}"
                                id="btn-hapus" data-target="#modal-hapus">Hapus</button>
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

            $('#form-hapus').attr('action', '/user/' + id);
        });
    </script>
@endsection
