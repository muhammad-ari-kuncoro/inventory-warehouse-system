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
                    <a href="{{ route('machine.index') }}" class="text-primary text-decoration-none">Machines</a>
                </li>
                <li class="breadcrumb-item active">Export PDF</li>
            </ol>
        </nav>
    </div>

    <div class="card-body">
        <h5 class="card-title mb-4">Filter Export Data Machines</h5>

        <form action="{{ route('machine.machine.export.download') }}" method="GET" target="_blank">

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="projectFilterMaterial" class="form-label fw-semibold">Filter Type Machines</label>
                    <select id="projectFilterMaterial" class="form-select">
                        <option disabled>Choose Type</option>
                        <option value="">All Type</option>
                        <option value="Cutting Machines">Cutting Machines</option>
                        <option value="Forming Machines">Forming Machines</option>
                        <option value="Welding Machines">Welding Machines</option>
                        <option value="Machining Machines">Machining Machines</option>
                        <option value="Surface Treatment Machines">Surface Treatment Machines</option>
                        <option value="spesial machines">spesial machines</option>
                        <option value="Pipe Bending">Pipe Bending</option>
                    </select>
                </div>
            </div>

            <div class="alert alert-info mt-4 mb-0 d-flex align-items-center gap-2">
                <i class='bx bx-info-circle fs-5'></i>
                <span>Clear the filter to export all data machine.</span>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('machine.index') }}" class="btn btn-secondary">
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
        const endDate = document.querySelector('[name="end_date"]');

        startDate.addEventListener('change', function () {
            endDate.min = this.value;
        });
    });

</script>
@endpush
