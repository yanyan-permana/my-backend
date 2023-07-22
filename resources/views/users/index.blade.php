@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pengguna</h1>
        </div>

        @if (session('success'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <a href="/user/create" class="btn btn-primary">Buat Baru</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>User Login</th>
                                        <th>Hak Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($user as $usr)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $usr['kry_nama'] }}</td>
                                            <td>
                                                <a href="/user/{{ $usr['usr_id'] }}/edit">{{ $usr['usr_login'] }}</a>
                                            </td>
                                            <td>{{ ucfirst($usr['usr_hak_akses']) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
