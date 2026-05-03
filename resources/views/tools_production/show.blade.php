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
                    <a href="{{ route('material.index') }}" class="text-primary text-decoration-none">Materials</a>
                </li>
                <li class="breadcrumb-item active">Detail Tools</li>
            </ol>
        </nav>
    </div>

    <div class="card-body">
        <h5 class="card-title mb-4">Detail Tools Information</h5>

        <div class="row g-3">

            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Name Tools</small>
                    <p class="fw-semibold mb-0 mt-1">{{ $find_id->nama_alat ?? '-' }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Spesification Tools</small>
                    <p class="fw-semibold mb-0 mt-1">{{ $find_id->spesifikasi_alat ?? '-' }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Quantity</small>
                    <p class="fw-semibold mb-0 mt-1 {{ $find_id->quantity == 0 ? 'text-danger' : '' }}">
                        {{ $find_id->quantity ?? '-' }} {{ $find_id->jenis_quantity ?? '-' }}
                        @if($find_id->quantity == 0)
                        <span class="badge bg-danger ms-1">Out of Stock</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Type Tools</small>
                    <p class="fw-semibold mb-0 mt-1">
                        @if ($find_id->tipe_alat === 'Medium')
                        <span class="badge bg-warning">{{ $find_id->tipe_alat ?? '-' }}</span>
                        @elseif ($find_id->tipe_alat === 'Large')
                        <span class="badge bg-danger">{{ $find_id->tipe_alat ?? '-' }}</span>
                        @elseif ($find_id->tipe_alat === 'Small')
                        <span class="badge bg-primary">{{ $find_id->tipe_alat ?? '-' }}</span>
                        @else
                        <span class="badge bg-secondary">{{ $find_id->tipe_alat ?? '-' }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Date Added</small>
                    <p class="fw-semibold mb-0 mt-1">{{ $find_id->created_at->format('d M Y') }}</p>
                </div>
            </div>

        </div>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('tools.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('tools.edit', $find_id->id) }}" class="btn btn-warning">Edit</a>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);
    });

</script>
@endpush
