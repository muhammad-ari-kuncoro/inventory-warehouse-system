@extends('layouts.dashboard-layout')
@section('container')

<div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size: 13px;">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-primary">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('machine.index') }}" class="text-decoration-none text-primary">Machines</a>
            </li>
            <li class="breadcrumb-item active text-secondary">Detail Machine</li>
        </ol>
    </nav>
</div>

<h5 class="fw-medium mb-4" style="font-size: 18px;">Detail Machine</h5>

<div class="card border shadow-sm mb-3">
    <div class="card-header bg-transparent border-bottom py-3 px-4">
        <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
            Information Description Machine
        </p>
    </div>
    <div class="card-body px-4 py-3">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted" style="font-size: 11px;">Machine Name</small>
                    <p class="fw-semibold mb-0 mt-1" style="font-size: 14px;">{{ $find_id->nama_mesin ?? '-' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted" style="font-size: 11px;">Machine Specification</small>
                    <p class="fw-semibold mb-0 mt-1" style="font-size: 14px;">{{ $find_id->spesifikasi_mesin ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border shadow-sm mb-3">
    <div class="card-header bg-transparent border-bottom py-3 px-4">
        <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
            Information Quantity Machine
        </p>
    </div>
    <div class="card-body px-4 py-3">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted" style="font-size: 11px;">Quantity</small>
                    <p class="fw-semibold mb-0 mt-1 {{ $find_id->quantity == 0 ? 'text-danger' : '' }}" style="font-size: 14px;">
                        {{ $find_id->quantity ?? '-' }}
                        @if($find_id->quantity == 0)
                            <span class="badge bg-danger ms-1">Out of Stock</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted" style="font-size: 11px;">Quantity Type</small>
                    <p class="fw-semibold mb-0 mt-1">
                        <span class="badge bg-info text-dark">{{ $find_id->jenis_quantity ?? '-' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border shadow-sm mb-4">
    <div class="card-header bg-transparent border-bottom py-3 px-4">
        <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
            Type & Price
        </p>
    </div>
    <div class="card-body px-4 py-3">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted" style="font-size: 11px;">Machine Type</small>
                    <p class="fw-semibold mb-0 mt-1">
                        <span class="badge bg-primary">{{ $find_id->jenis_mesin ?? '-' }}</span>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted" style="font-size: 11px;">Machine Price</small>
                    <p class="fw-semibold mb-0 mt-1" id="machinePrice" style="font-size: 14px;">
                        {{ $find_id->harga_mesin ?? 0 }}
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted" style="font-size: 11px;">Date Added</small>
                    <p class="fw-semibold mb-0 mt-1" style="font-size: 14px;">
                        {{ $find_id->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2">
    <a href="{{ route('machine.index') }}" class="btn btn-light border px-4" style="font-size: 14px;">Back</a>
    <a href="{{ route('machine.edit', $find_id->id) }}" class="btn btn-warning px-4" style="font-size: 14px;">Edit</a>
</div>

@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);

        const el = document.getElementById('machinePrice');
        const raw = el.innerText.replace(/[^\d]/g, '');
        const number = raw ? parseInt(raw) : 0;
        el.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    });
</script>
@endpush
