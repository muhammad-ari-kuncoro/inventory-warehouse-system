@extends('layouts.dashboard-layout')
@section('container')
<div class="card">
    <h5 class="card-header">Dashboard Menu Consumables</h5>
     {{-- Session Flash Data --}}
     @if (session('success'))
     <div class="alert alert-success alert-dismissible fade show" role="alert">
         <strong class="text-dark">{!! session()->get('success') !!}</strong>
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
     @elseif (session('delete'))
     <div class="alert alert-danger alert-dismissible fade show" role="alert">
         <strong class="text-dark">Data Telah Dihapus</strong>
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
     @elseif (session('editSuccess'))
     <div class="alert alert-warning alert-dismissible fade show" role="alert">
         <strong class="text-dark">{!! session()->get('editSuccess') !!}</strong>
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
     @endif
    <div class="card-body">

    {{-- Tampilan Button Data Dan Print  --}}
    <div class="row align-items-center mb-2">
        <!-- Print Button -->
        <div class="col-sm-2 mb-3">
            <a href="" class="btn btn-success w-100">Print Data</a>
        </div>

        <!-- Add Button -->
        <div class="col-sm-2 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah Data
            </button>
        </div>

        <!-- Tampilan Pencarian -->
        <div class="col mb-3">
            <form action="{{ route('material.index') }}" method="get" class="d-flex align-items-center">
                <input class="form-control me-2" type="text" name="search" placeholder="Pencarian" value="{{ $search ?? '' }}">
                <button type="submit" name="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
    </div>


    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="table-info text-center">
                    <th>No</th>
                    <th>Nama Consumables</th>
                    <th>Spesifikasi Consumables</th>
                    <th>Kode Materials</th>
                    <th>Quantity</th>
                    <th>Jenis Quantity</th>
                    <th>Jenis Consumables</th>
                    <th>Nama Project</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>

    </div>
  </div>
@endsection
