@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jenis Approval</h1>
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
                    {{-- <div class="card-header">
                        <a href="/jenis-approval/create" class="btn btn-primary">Buat Baru</a>
                    </div> --}}
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis</th>
                                        <th>Nama</th>
                                        <th>Minimal Nominal</th>
                                        <th>Maximal Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($jenisApproval as $ja)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                <a href="/jenis-approval/{{ $ja->app_id }}/edit">{{ $ja->app_jenis }}</a>
                                            </td>
                                            <td>{{ $ja->app_nama }}</td>
                                            <td>{{ number_format($ja->app_min_nom, 0, ',', '.') }}</td>
                                            <td>{{ number_format($ja->app_max_nom, 0, ',', '.') }}</td>
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
