@extends('layouts.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Bayi</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Data Bayi</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <button type="button" class="btn btn-primary btn-icon-text" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="btn-icon-prepend" data-feather="printer"></i>
            Cetak
        </button>
    </div>
</div>

@include('components.alert')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Data Bayi</h6>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Petugas Posyandu</th>
                                <th>Nama Bayi</th>
                                <th>Nama Ayah</th>
                                <th>Nama Ibu</th>
                                <th>Tanggal Lahir Bayi</th>
                                <th>Umur Bayi</th>
                                <th>Tanggal Pengecekan</th>
                                <th>Tinggi Badan</th>
                                <th>Berat Badan</th>
                                <th>Jenis Kelamin</th>
                                <th>Status Gizi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->nama_bayi }}</td>
                                <td>{{ $item->nama_ayah }}</td>
                                <td>{{ $item->nama_ibu }}</td>
                                <td>{{ $item->tgl_lahir_bayi }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tgl_lahir_bayi)->diffInMonths(\Carbon\Carbon::now()) }} Bulan</td>
                                <td>{{ $item->tgl_pengecekan }}</td>
                                <td>{{ $item->tb }}</td>
                                <td>{{ $item->bb }}</td>
                                <td>{{ $item->jkel }}</td>
                                <td>
                                    @if ($item->status == 'BURUK')
                                    <span class="badge bg-warning">{{ $item->status }}</span>
                                    @else
                                    <span class="badge bg-success">{{ $item->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Status Gizi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pendataan.cetak-report') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="checkbox" id="pil1" name="pilihan[]" value="Underweight">
                        <label for="pil1"> Underweight</label><br>
                        <input type="checkbox" id="pil2" name="pilihan[]" value="Overweight">
                        <label for="pil2"> Overweight</label><br>
                        <input type="checkbox" id="pil3" name="pilihan[]" value="Stunted">
                        <label for="pil3"> Stunted</label><br>
                        <input type="checkbox" id="pil4" name="pilihan[]" value="Tinggi">
                        <label for="pil4"> Tinggi</label><br>
                        <input type="checkbox" id="pil5" name="pilihan[]" value="Normal">
                        <label for="pil5"> Normal</label><br>
                        <input type="checkbox" id="pil6" name="pilihan[]" value="Tidak Diketahui">
                        <label for="pil6"> Tidak Diketahui</label><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveData">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush
