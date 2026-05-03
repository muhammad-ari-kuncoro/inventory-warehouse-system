@extends('layouts.dashboard-layout')
@section('container')

<div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size: 13px;">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-primary">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('tools.index') }}" class="text-decoration-none text-primary">Tools</a>
            </li>
            <li class="breadcrumb-item active text-secondary">Edit Tools</li>
        </ol>
    </nav>
</div>

<h5 class="fw-medium mb-4" style="font-size: 18px;">Edit Tools</h5>

<form action="{{ route('tools.update', $find_id->id) }}" method="POST">
    @csrf
    @method('PATCH')

    {{-- Card 1: Tool Description --}}
    <div class="card border shadow-sm mb-3">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
                Information Description Tools
            </p>
        </div>
        <div class="card-body px-4 py-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Tool Name</label>
                    <input type="text"
                        class="form-control @error('nama_alat') is-invalid @enderror"
                        name="nama_alat"
                        value="{{ old('nama_alat', $find_id->nama_alat) }}"
                        placeholder="Please fill in the Tools name field ..." required>
                    @error('nama_alat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Specification Tool</label>
                    <input type="text"
                        class="form-control @error('spesifikasi_alat') is-invalid @enderror"
                        name="spesifikasi_alat"
                        value="{{ old('spesifikasi_alat', $find_id->spesifikasi_alat) }}"
                        placeholder="Please fill in the Specification Tool field ..." required>
                    @error('spesifikasi_alat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: Type & Size --}}
    <div class="card border shadow-sm mb-3">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
                Type & Size Tools
            </p>
        </div>
        <div class="card-body px-4 py-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">
                        Type Tools
                        <span class="ms-1 text-muted">— current:</span>
                        <span class="badge bg-secondary fw-normal ms-1" style="font-size: 10px;">
                            {{ $find_id->jenis_alat ?? '-' }}
                        </span>
                    </label>
                    <select class="form-select select2-type-tools @error('jenis_alat') is-invalid @enderror"
                        name="jenis_alat" required>
                        <option value="">Select Type Tools</option>
                        @foreach (['Cutting Tools', 'Lifting Tools', 'Forming Tools', 'Fastener Tools', 'Measuring Tools', 'Tester Tools'] as $type)
                            <option value="{{ $type }}"
                                {{ old('jenis_alat', $find_id->jenis_alat) == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_alat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">
                        Size Tools
                        <span class="ms-1 text-muted">— current:</span>
                        @if ($find_id->tipe_alat === 'Large')
                        <span class="badge bg-danger fw-normal ms-1" style="font-size: 10px;">
                            {{ $find_id->tipe_alat ?? '-' }}
                        </span>
                        @elseif ($find_id->tipe_alat === 'Medium')
                        <span class="badge bg-warning fw-normal ms-1" style="font-size: 10px;">
                            {{ $find_id->tipe_alat ?? '-' }}
                        </span>
                        @elseif ($find_id->tipe_alat === 'Small')
                        <span class="badge bg-primary fw-normal ms-1" style="font-size: 10px;">
                            {{ $find_id->tipe_alat ?? '-' }}
                        </span>
                        @endif
                    </label>
                    <select class="form-select select2-size-tools @error('tipe_alat') is-invalid @enderror"
                        name="tipe_alat" required>
                        <option value="">Select Size Tools</option>
                        @foreach (['Small', 'Medium', 'Large'] as $size)
                            <option value="{{ $size }}"
                                {{ old('tipe_alat', $find_id->tipe_alat) == $size ? 'selected' : '' }}>
                                {{ $size }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipe_alat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Card 3: Quantity --}}
    <div class="card border shadow-sm mb-4">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
                Information Quantity Tools
            </p>
        </div>
        <div class="card-body px-4 py-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Quantity</label>
                    <input type="number"
                        class="form-control @error('quantity') is-invalid @enderror"
                        name="quantity"
                        value="{{ old('quantity', $find_id->quantity) }}"
                        placeholder="0" min="1" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">
                        Type Quantity
                        <span class="ms-1 text-muted">— current:</span>
                        <span class="badge bg-secondary fw-normal ms-1" style="font-size: 10px;">
                            {{ $find_id->jenis_quantity ?? '-' }}
                        </span>
                    </label>
                    <select class="form-select select2-type-qty @error('jenis_quantity') is-invalid @enderror"
                        name="jenis_quantity" required>
                        <option value="">Select Type Quantity</option>
                        @foreach (['Unit', 'Pcs', 'Set', 'Lot', 'Pack'] as $qty)
                            <option value="{{ $qty }}"
                                {{ old('jenis_quantity', $find_id->jenis_quantity) == $qty ? 'selected' : '' }}>
                                {{ $qty }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('tools.index') }}" class="btn btn-light border px-4" style="font-size: 14px;">Cancel</a>
        <button type="submit" class="btn btn-primary px-4" style="font-size: 14px;">Save Changes</button>
    </div>

</form>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);
    });

    $(document).ready(function () {
        $('.select2-type-tools').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Select Type Tools',
        });

        $('.select2-size-tools').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Select Size Tools',
        });

        $('.select2-type-qty').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Select Type Quantity',
        });
    });
</script>
@endpush
