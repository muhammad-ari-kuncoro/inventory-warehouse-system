@extends('layouts.dashboard-layout')
@section('container')

<div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size: 13px;">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-primary">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('tools.index') }}" class="text-decoration-none text-primary">Machines</a>
            </li>
            <li class="breadcrumb-item active text-secondary">Edit Machine</li>
        </ol>
    </nav>
</div>

<h5 class="fw-medium mb-4" style="font-size: 18px;">Edit Machine</h5>

<form action="{{ route('machine.update', $find_id->id) }}" method="POST">
    @csrf
    @method('PATCH')

    {{-- INFORMATION DESCRIPTION --}}
    <div class="card border shadow-sm mb-3">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
                Information Description Machine
            </p>
        </div>
        <div class="card-body px-4 py-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Machine Name</label>
                    <input type="text"
                        class="form-control @error('nama_mesin') is-invalid @enderror"
                        name="nama_mesin"
                        value="{{ old('nama_mesin', $find_id->nama_mesin) }}"
                        placeholder="Enter machine name..." required>
                    @error('nama_mesin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Machine Specification</label>
                    <input type="text"
                        class="form-control @error('spesifikasi_mesin') is-invalid @enderror"
                        name="spesifikasi_mesin"
                        value="{{ old('spesifikasi_mesin', $find_id->spesifikasi_mesin) }}"
                        placeholder="Enter machine specification..." required>
                    @error('spesifikasi_mesin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- QUANTITY --}}
    <div class="card border shadow-sm mb-3">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
                Information Quantity Machine
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
                        Quantity Type
                        <span class="ms-1 text-muted">— current:</span>
                        <span class="badge bg-secondary fw-normal ms-1" style="font-size: 10px;">
                            {{ $find_id->jenis_quantity ?? '-' }}
                        </span>
                    </label>
                    <select class="select-jenis-quantity @error('jenis_quantity') is-invalid @enderror"
                        name="jenis_quantity" required>
                        <option value="" disabled>-- Choose Type --</option>
                        @foreach (['Unit', 'Pcs', 'Set'] as $jenis)
                            <option value="{{ $jenis }}"
                                {{ old('jenis_quantity', $find_id->jenis_quantity) == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
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

    {{-- TYPE & PRICE --}}
    <div class="card border shadow-sm mb-3">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
                Type & Price
            </p>
        </div>
        <div class="card-body px-4 py-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">
                        Machine Type
                        <span class="ms-1 text-muted">— current:</span>
                        <span class="badge bg-secondary fw-normal ms-1" style="font-size: 10px;">
                            {{ $find_id->jenis_mesin ?? '-' }}
                        </span>
                    </label>
                    <select class="select-jenis-mesin @error('jenis_mesin') is-invalid @enderror"
                        name="jenis_mesin" required>
                        <option value="" disabled>-- Choose Type --</option>
                        @foreach ([
                            'Cutting Machines',
                            'Forming Machines',
                            'Welding Machines',
                            'Machining Machines',
                            'Surface Treatment Machines',
                            'Special Machines',
                            'Pipe Bending Machines',
                        ] as $jenis)
                            <option value="{{ $jenis }}"
                                {{ old('jenis_mesin', $find_id->jenis_mesin) == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_mesin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Machine Price</label>
                    <div class="input-group">
                        <span class="input-group-text text-secondary" style="font-size: 13px;">Rp</span>
                        <input type="text"
                            class="form-control"
                            name="harga_mesin"
                            id="hargaMesin"
                            placeholder="0"
                            value="{{ old('harga_mesin', $find_id->harga_mesin) }}"
                            oninput="formatCurrency(this)">
                    </div>
                    @error('harga_mesin')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
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
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    function formatCurrency(input) {
        let value = input.value.replace(/[^,\d]/g, '');
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);
    });

    $(document).ready(function () {
        $('.select-jenis-quantity').select2({
            width: '100%',
            placeholder: "Choose Quantity Type"
        });
        $('.select-jenis-mesin').select2({
            width: '100%',
            placeholder: "Choose Machine Type"
        });
    });
</script>
@endpush
