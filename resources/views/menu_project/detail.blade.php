@extends('layouts.dashboard-layout')
@section('container')

<div class="card">
    <h5 class="card-header text-center bg-primary text-white">
        Detail Project
    </h5>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nama_project" class="form-label fw-bold">Nama Project</label>
                <p class="form-control-plaintext">{{ $find_id->nama_project }}</p>
            </div>
            <div class="col-md-6">
                <label for="sub_nama_project" class="form-label fw-bold">Sub Nama Project</label>
                <p class="form-control-plaintext">{{ $find_id->sub_nama_project }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="kategori_project" class="form-label fw-bold">Kategori Project</label>
                <p class="form-control-plaintext">{{ $find_id->kategori_project }}</p>
            </div>
            <div class="col-md-6">
                <label for="no_jo_project" class="form-label fw-bold">No Jo Project</label>
                <p class="form-control-plaintext">{{ $find_id->no_jo_project }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="no_po_project" class="form-label fw-bold">No Po Project</label>
                <p class="form-control-plaintext">{{ $find_id->no_po_project }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <a href="{{ route('project.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            console.log('Preloader found. It will hide after 3 seconds...');
            setTimeout(function () {
                preloader.style.display = 'none'; // Sembunyikan preloader setelah 3 detik
                console.log('Preloader hidden.');
            }, 1500); // Durasi 3000 ms = 3 detik
        } else {
            console.error('Preloader element not found!');
        }
    });

</script>
