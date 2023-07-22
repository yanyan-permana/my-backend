@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Pejabat Approval</h1>
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
                        <form action="/pejabat-approval" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="app_id">Jenis Approval *</label>
                                <select name="app_id" id="app_id" class="form-control">
                                    @foreach ($jenisApproval as $ja)
                                        <option value="{{ $ja->app_id }}"
                                            {{ old('app_id') === $ja->app_id ? 'selected' : '' }}>{{ $ja->app_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="usr_id">User *</label>
                                <select name="usr_id" id="usr_id" class="form-control">
                                    @foreach ($user as $usr)
                                        <option value="{{ $usr->usr_id }}"
                                            {{ old('usr_id') === $usr->usr_id ? 'selected' : '' }}>{{ $usr->usr_login }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="app_auth_user">Username *</label>
                                <input type="text" class="form-control" name="app_auth_user" id="app_auth_user" value="{{ old('app_auth_user') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="app_auth_password">Password *</label>
                                <input type="text" class="form-control" name="app_auth_password" id="app_auth_password" value="{{ old('app_auth_password') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="pjbt_status">Status *</label>
                                <select name="pjbt_status" id="pjbt_status" class="form-control">
                                    <option value="Active" {{ old('pjbt_status') === 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('pjbt_status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
