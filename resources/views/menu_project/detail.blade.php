@extends('layouts.dashboard-layout')
@section('container')

<div class="card shadow-sm border-0">
    <div class="card-header bg-light">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('project.index') }}" class="text-primary text-decoration-none">Project</a>
                </li>
                <li class="breadcrumb-item active">Detail Project</li>
            </ol>
        </nav>
    </div>

    <div class="card-body">
        <h5 class="card-title mb-4">Informasi Project</h5>

        <div class="row g-3">

            {{-- Nama Project --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Nama Project</small>
                    <p class="fw-semibold mb-0 mt-1">{{ $find_id->nama_project ?? '-' }}</p>
                </div>
            </div>

            {{-- Sub Nama Project --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Sub Nama Project</small>
                    <p class="fw-semibold mb-0 mt-1">{{ $find_id->sub_nama_project ?? '-' }}</p>
                </div>
            </div>

            {{-- Kategori Project --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Kategori Project</small>
                    <p class="fw-semibold mb-0 mt-1">
                        <span class="badge bg-primary">{{ $find_id->kategori_project ?? '-' }}</span>
                    </p>
                </div>
            </div>

            {{-- No JO Project --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">No. JO Project</small>
                    <p class="fw-semibold mb-0 mt-1">{{ $find_id->no_jo_project ?? '-' }}</p>
                </div>
            </div>

            {{-- No PO Project --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">No. PO Project</small>
                    <p class="fw-semibold mb-0 mt-1">{{ $find_id->no_po_project ?? '-' }}</p>
                </div>
            </div>

            {{-- Tanggal Dibuat --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Tanggal Dibuat</small>
                    <p class="fw-semibold mb-0 mt-1">{{ $find_id->created_at->format('d M Y') }}</p>
                </div>
            </div>

        </div>

        {{-- Tombol --}}
        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('project.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('project.edit', $find_id->id) }}" class="btn btn-warning">Edit</a>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            setTimeout(() => preloader.style.display = 'none', 1500);
        }
    });
</script>
@endpush
