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
                    <a href="{{ route('tools.index') }}" class="text-primary text-decoration-none">Tools</a>
                </li>
                <li class="breadcrumb-item active">Export PDF</li>
            </ol>
        </nav>
    </div>

    <div class="card-body">
        <h5 class="card-title mb-4">Filter Export Data Tools</h5>
        <form action="{{ route('tools.tools.export.download') }}" method="GET" target="_blank">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Type Tools</label>
                        <select class="form-select select2-type-tools @error('jenis_alat') is-invalid @enderror"
                            name="jenis_alat" required>
                            <option value="" disabled>Select Type Tools</option>
                            <option value="">All Data</option>
                            <option value="Cutting Tools">Cutting Tools</option>
                            <option value="Lifting Tools">Lifting Tools</option>
                            <option value="Forming Tools">Forming Tools</option>
                            <option value="Fastener Tools">Fastener Tools</option>
                            <option value="Measuring Tools">Measuring Tools</option>
                            <option value="Tester Tools">Tester Tools</option>
                        </select>
                        @error('jenis_alat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>
            </div>
            <div class="alert alert-info mt-4 mb-0 d-flex align-items-center gap-2">
                <i class='bx bx-info-circle fs-5'></i>
                <span>Clear the filter to export all data Tools.</span>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('tools.index') }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Back
                </a>
                <button type="submit" class="btn btn-danger">
                    <i class='bx bxs-file-pdf'></i> Export PDF
                </button>
            </div>

        </form>
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
