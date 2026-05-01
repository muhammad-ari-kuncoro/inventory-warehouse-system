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
            <h5 class="card-title mb-4">Information Project</h5>

            <div class="row g-3">

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted">Code Project</small>
                        <p class="fw-semibold mb-0 mt-1">{{ $find_id->kode_project ?? '-' }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted">Name Project Client</small>
                        <p class="fw-semibold mb-0 mt-1">{{ $find_id->nama_project ?? '-' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted">Project Item</small>
                        <p class="fw-semibold mb-0 mt-1">{{ $find_id->sub_nama_project ?? '-' }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted">Category Project</small>
                        <p class="fw-semibold mb-0 mt-1">
                            <span class="badge bg-primary">{{ $find_id->kategori_project ?? '-' }}</span>
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted">No. JO (Job Order) Project</small>
                        <p class="fw-semibold mb-0 mt-1">{{ $find_id->no_jo_project ?? '-' }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted">No. PO(Purchase Order) Project</small>
                        <p class="fw-semibold mb-0 mt-1">{{ $find_id->no_po_project ?? '-' }}</p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 border-start border-4 border-primary bg-light rounded shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3 text-primary">
                                    <i class='bx bx-calendar-check fs-3'></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase fw-bold"
                                        style="font-size: 0.7rem; letter-spacing: 1px;">Project Start Date</small>
                                    <p class="fw-bold mb-0 mt-1 text-dark">
                                        {{ \Carbon\Carbon::parse($find_id->start_date)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 border-start border-4 border-danger bg-light rounded shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3 text-danger">
                                    <i class='bx bx-calendar-x fs-3'></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase fw-bold"
                                        style="font-size: 0.7rem; letter-spacing: 1px;">Project End Date</small>
                                    <p class="fw-bold mb-0 mt-1 text-dark">
                                        {{ \Carbon\Carbon::parse($find_id->end_date)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('project.index') }}" class="btn btn-secondary">Go Back</a>
                <a href="{{ route('project.edit', $find_id->id) }}" class="btn btn-warning">Edit</a>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                setTimeout(() => preloader.style.display = 'none', 1500);
            }
        });
    </script>
@endpush
