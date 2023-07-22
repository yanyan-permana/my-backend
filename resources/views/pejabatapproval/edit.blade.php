@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Pejabat Approval</h1>
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
                        <form action="/pejabat-approval/{{ $pejabatApproval->pjbt_id }}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="app_id">Jenis Approval *</label>
                                <select name="app_id" id="app_id" class="form-control">
                                    @foreach ($jenisApproval as $ja)
                                        <option value="{{ $ja->app_id }}"
                                            {{ $pejabatApproval->app_id === $ja->app_id ? 'selected' : '' }}>{{ $ja->app_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr_id">User *</label>
                                <select name="usr_id" id="usr_id" class="form-control">
                                    @foreach ($user as $usr)
                                        <option value="{{ $usr->usr_id }}"
                                            {{ $pejabatApproval->usr_id === $usr->usr_id ? 'selected' : '' }}>{{ $usr->usr_login }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="app_auth_user">Username *</label>
                                <input type="text" class="form-control" name="app_auth_user" id="app_auth_user"
                                    value="{{ $pejabatApproval->app_auth_user }}" required>
                            </div>
                            <div class="form-group">
                                <label for="app_auth_password">Password *</label>
                                <input type="text" class="form-control" name="app_auth_password" id="app_auth_password"
                                    value="{{ $pejabatApproval->app_auth_password }}" required>
                            </div>
                            <div class="form-group">
                                <label for="pjbt_status">Status *</label>
                                <select name="pjbt_status" id="pjbt_status" class="form-control">
                                    <option value="Active" {{ $pejabatApproval->pjbt_status === 'Active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="Inactive" {{ $pejabatApproval->pjbt_status === 'Inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-id="{{ $pejabatApproval->pjbt_id }}" id="btn-hapus"
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

            $('#form-hapus').attr('action', '/pejabat-approval/' + id);
        });
    </script>
@endsection
