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
                    <a href="{{ route('consumable.index') }}" class="text-primary text-decoration-none">Consumables</a>
                </li>
                <li class="breadcrumb-item active">Detail Consumable</li>
            </ol>
        </nav>
    </div>

    <div class="card-body">
        <h5 class="card-title mb-4">Detail Consumable Information</h5>

        <div class="row g-3">

            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Consumable Name</small>
                    <p class="fw-semibold mb-0 mt-1">{{ $find_id->nama_consumable ?? '-' }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Specification</small>
                    <p class="fw-semibold mb-0 mt-1">{{ $find_id->spesifikasi_consumable ?? '-' }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Quantity</small>
                    <p class="fw-semibold mb-0 mt-1 {{ $find_id->quantity == 0 ? 'text-danger' : '' }}">
                        {{ $find_id->quantity ?? '-' }}    <span class="badge bg-info text-dark">{{ $find_id->jenis_quantity ?? '-' }}</span>
                        @if($find_id->quantity == 0)
                            <span class="badge bg-danger ms-1">Out of Stock</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Type Consumable</small>
                    <p class="fw-semibold mb-0 mt-1">
                        <span class="badge bg-primary">{{ $find_id->jenis_consumable ?? '-' }}</span>
                    </p>
                </div>
            </div>

            <div class="col-md-6">
    <div class="p-3 bg-light rounded">
        <small class="text-muted">Consumable Price</small>
        <p class="fw-semibold mb-0 mt-1" id="consumablePrice">
            {{ $find_id->harga_consumable ?? 0 }}
        </p>
    </div>
</div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted">Project</small>
                    <p class="fw-semibold mb-0 mt-1">{{ $find_id->project->nama_project ?? '-' }}</p>
                    <small class="text-muted">{{ $find_id->project->sub_nama_project ?? '-' }}</small>
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
            <a href="{{ route('consumable.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('consumable.edit', $find_id->id) }}" class="btn btn-warning">Edit</a>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);



    let el = document.getElementById("consumablePrice");

    // ambil text & bersihin selain angka
    let raw = el.innerText.replace(/[^\d]/g, '');

    // handle kalau kosong
    let number = raw ? parseInt(raw) : 0;

    let formatted = new Intl.NumberFormat('id-ID').format(number);

    el.innerText = "Rp " + formatted;
    });


function formatTextCurrency(element) {
    let value = element.innerText.replace(/[^,\d]/g, '');
    element.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(value);
}

</script>
@endpush
