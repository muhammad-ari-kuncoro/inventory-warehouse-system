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
                    <a href="{{ route('good-received.index') }}" class="text-primary text-decoration-none">Goods Received</a>
                </li>
                <li class="breadcrumb-item active">Export PDF</li>
            </ol>
        </nav>
    </div>

    <div class="card-body">
        <h5 class="card-title mb-4">Filter Export Data Goods Received</h5>

        <form action="{{ route('good-received.export.download') }}" method="GET" target="_blank">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Project</label>
                    <select class="form-select" name="project_id">
                        <option value="">All Project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">
                                {{ $project->nama_project }} | JO: {{ $project->no_jo_project }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status</label>
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="received">Received</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Type Item</label>
                    <select class="form-select" name="jenis_barang">
                        <option value="">All Type</option>
                        <option value="material">Material</option>
                        <option value="consumable">Consumable</option>
                        <option value="machine">Machine Asset</option>
                    </select>
                </div>

                <div class="col-md-6 d-none d-md-block"></div>

            </div>

            <div class="alert alert-info mt-4 mb-0 d-flex align-items-center gap-2">
                <i class='bx bx-info-circle fs-5'></i>
                <span>Clear the filter to export all goods receipt data.</span>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('good-received.index') }}" class="btn btn-secondary">
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

        const startDate = document.querySelector('[name="start_date"]');
        const endDate   = document.querySelector('[name="end_date"]');

        startDate.addEventListener('change', function () {
            endDate.min = this.value;
        });
    });
</script>
@endpush
