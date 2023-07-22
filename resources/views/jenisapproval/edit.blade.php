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
                                <input type="text" class="form-control"id="app_jenis"
                                    value="{{ $jenisApproval->app_jenis }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="app_nama">Nama *</label>
                                <input type="text" class="form-control"id="app_nama"
                                    value="{{ $jenisApproval->app_nama }}" disabled>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
