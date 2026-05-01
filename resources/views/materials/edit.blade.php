@extends('layouts.dashboard-layout')
@section('container')

<div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size: 13px;">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-primary">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('material.index') }}" class="text-decoration-none text-primary">Materials</a>
            </li>
            <li class="breadcrumb-item active text-secondary">Edit Material</li>
        </ol>
    </nav>
</div>

<h5 class="fw-medium mb-4" style="font-size: 18px;">Edit Material</h5>

<form action="{{ route('material.update', $find_id->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="card border shadow-sm mb-3">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
                INFORMATION DESCRIPTION ITEM
            </p>
        </div>
        <div class="card-body px-4 py-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Material Name</label>
                    <input type="text"
                        class="form-control @error('nama_material') is-invalid @enderror"
                        name="nama_material"
                        value="{{ old('nama_material', $find_id->nama_material) }}"
                        placeholder="Enter material name..." required>
                    @error('nama_material')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Specification Material</label>
                    <input type="text"
                        class="form-control @error('spesifikasi_material') is-invalid @enderror"
                        name="spesifikasi_material"
                        value="{{ old('spesifikasi_material', $find_id->spesifikasi_material) }}"
                        placeholder="Enter specification material..." required>
                    @error('spesifikasi_material')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card border shadow-sm mb-3">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
                INFORMATION QUANTITY ITEM
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
                    <select class="select-type-quantity @error('jenis_quantity') is-invalid @enderror"
                        name="jenis_quantity" required>
                        <option value="" disabled>-- Choose Type --</option>
                        @foreach (['Pcs', 'Rod', 'Set', 'Sack', 'Box', 'Ea'] as $jenis)
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

    <div class="card border shadow-sm mb-3">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
                TYPE & PRICE
            </p>
        </div>
        <div class="card-body px-4 py-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">
                        Type Material
                        <span class="ms-1 text-muted">— current:</span>
                        <span class="badge bg-secondary fw-normal ms-1" style="font-size: 10px;">
                            {{ $find_id->jenis_material ?? '-' }}
                        </span>
                    </label>
                    <select class="form-select @error('jenis_material') is-invalid @enderror"
                        name="jenis_material" required>
                        <option value="" disabled>-- Choose Type --</option>
                        @foreach (['New', 'Temporary'] as $jenis)
                            <option value="{{ $jenis }}"
                                {{ old('jenis_material', $find_id->jenis_material) == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_material')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Material Price</label>
                    <div class="input-group">
                        <span class="input-group-text text-secondary" style="font-size: 13px;">Rp</span>
                        <input type="text"
                            class="form-control"
                            name="harga_material"
                            id="hargaMaterials"
                            placeholder="0"
                            value="{{ old('harga_material', $find_id->harga_material) }}"
                            oninput="formatCurrency(this)">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border shadow-sm mb-4">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
                PROJECT REQUIREMENTS
            </p>
        </div>
        <div class="card-body px-4 py-3">
            <label class="form-label text-secondary" style="font-size: 11px;">
                Project
                <span class="ms-1 text-muted">— current:</span>
                <span class="badge bg-secondary fw-normal ms-1" style="font-size: 10px;">
                    {{ $find_id->project->nama_project ?? '-' }}
                </span>
            </label>
            <select class="select-project @error('project_id') is-invalid @enderror"
                name="project_id" required>
                <option value="" disabled>-- Choose Project --</option>
                @foreach ($data_project as $project)
                    <option value="{{ $project->id }}"
                        {{ old('project_id', $find_id->project_id) == $project->id ? 'selected' : '' }}>
                        {{ $project->nama_project }} | {{ $project->sub_nama_project }} | JO: {{ $project->no_jo_project }}
                    </option>
                @endforeach
            </select>
            @error('project_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('material.index') }}" class="btn btn-light border px-4" style="font-size: 14px;">Cancel</a>
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
        $('.select-type-quantity').select2({
            width: '100%',
            placeholder: "Choose Type Quantity"
        });
        $('.select-project').select2({
            width: '100%',
            placeholder: "Choose Project"
        });
    });
</script>
@endpush
