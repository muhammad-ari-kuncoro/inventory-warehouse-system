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
                    <a href="{{ route('consumable.index') }}" class="text-primary text-decoration-none">Consumable</a>
                </li>
                <li class="breadcrumb-item active">Export PDF</li>
            </ol>
        </nav>
    </div>

    <div class="card-body">
        <h5 class="card-title mb-4">Filter Export Data Consumable</h5>

        <form action="{{ route('consumable.consumable.export.download') }}" method="GET" target="_blank">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Project</label>
                    <select class="form-select" name="project_id">
                        <option value="">All Project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">
                                {{ $project->nama_project }} | {{ $project->sub_nama_project }} | JO: {{ $project->no_jo_project }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Type consumable</label>
                    <select class="form-select" name="jenis_consumable">
                        <option value="">All Type</option>
                        <option value="New">New</option>
                        <option value="Temporary">Temporary</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Project Start Date</label>
                    <input type="date" class="form-control" name="start_date">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Project End Date</label>
                    <input type="date" class="form-control" name="end_date">
                </div>

            </div>

            <div class="alert alert-info mt-4 mb-0 d-flex align-items-center gap-2">
                <i class='bx bx-info-circle fs-5'></i>
                <span>Clear the filter to export all data Consumable.</span>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('consumable.index') }}" class="btn btn-secondary">
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

        // Validasi tanggal: end_date tidak boleh kurang dari start_date
        const startDate = document.querySelector('[name="start_date"]');
        const endDate   = document.querySelector('[name="end_date"]');

        startDate.addEventListener('change', function () {
            endDate.min = this.value;
        });
    });
</script>
@endpush
