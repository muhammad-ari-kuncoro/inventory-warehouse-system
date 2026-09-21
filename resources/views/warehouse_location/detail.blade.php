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
                        <a href="{{ route('warehouses.index') }}" class="text-primary text-decoration-none">Warehouse Location</a>
                    </li>
                    <li class="breadcrumb-item active">Detail Warehouse Location</li>
                </ol>
            </nav>
        </div>

        <div class="card-body">
            <h5 class="card-title mb-4">Information Warehouse Location</h5>

            <div class="row g-3">

                <!-- Field: Warehouse Name -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted">Warehouse Name</small>
                        <p class="fw-semibold mb-0 mt-1">{{ $show_id->name ?? '-' }}</p>
                    </div>
                </div>

                <!-- Field: Warehouse Type -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted">Warehouse Type</small>
                        <p class="fw-semibold mb-0 mt-1">
                            @if($show_id->type == 'raw_material')
                                <span class="badge bg-info">Raw Material</span>
                            @elseif($show_id->type == 'wip')
                                <span class="badge bg-warning text-dark">WIP</span>
                            @elseif($show_id->type == 'finished_goods')
                                <span class="badge bg-success">Finished Goods</span>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Field: PIC -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted">PIC (Person in Charge)</small>
                        <p class="fw-semibold mb-0 mt-1">{{ $show_id->pic ?? '-' }}</p>
                    </div>
                </div>

                <!-- Field: Is Active (Status) -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted">Status</small>
                        <p class="fw-semibold mb-0 mt-1">
                            @if($show_id->is_active)
                                <span class="badge bg-primary">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Field: Address -->
                <div class="col-md-12">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted">Address</small>
                        <p class="fw-semibold mb-0 mt-1">{{ $show_id->address ?? '-' }}</p>
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="row g-3 mt-1">
                    <!-- Created At -->
                    <div class="col-md-6">
                        <div class="p-3 border-start border-4 border-primary bg-light rounded shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3 text-primary">
                                    <i class='bx bx-calendar-plus fs-3'></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase fw-bold"
                                        style="font-size: 0.7rem; letter-spacing: 1px;">Created At</small>
                                    <p class="fw-bold mb-0 mt-1 text-dark">
                                        {{ $show_id->created_at ? \Carbon\Carbon::parse($show_id->created_at)->format('d M Y, H:i') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Updated At -->
                    <div class="col-md-6">
                        <div class="p-3 border-start border-4 border-warning bg-light rounded shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3 text-warning">
                                    <i class='bx bx-calendar-edit fs-3'></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase fw-bold"
                                        style="font-size: 0.7rem; letter-spacing: 1px;">Last Updated</small>
                                    <p class="fw-bold mb-0 mt-1 text-dark">
                                        {{ $show_id->updated_at ? \Carbon\Carbon::parse($show_id->updated_at)->format('d M Y, H:i') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">Go Back</a>
                <a href="{{ route('warehouses.edit', $show_id->id) }}" class="btn btn-warning">Edit</a>
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
