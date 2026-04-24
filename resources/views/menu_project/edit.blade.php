@extends('layouts.dashboard-layout')
@section('container')
    <div class="card">
        <div class="card-header bg-light">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('project.index') }}" class="text-primary text-decoration-none">Project</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Data Project</li>
                </ol>
            </nav>
        </div>

        <div class="card-body">
            <form action="{{ route('project.update', $find_id->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="kode_project" class="form-label fw-semibold">Code Project</label>
                    <input type="text" class="form-control @error('kode_project') is-invalid @enderror" id="kode_project"
                        name="kode_project" value="{{ old('nama_project', $find_id->kode_project) }}"
                        placeholder="Please fill in the Code project name field ..." readonly disabled>
                    @error('nama_project')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_project" class="form-label fw-semibold">Client Project Name</label>
                    <input type="text" class="form-control @error('nama_project') is-invalid @enderror" id="nama_project"
                        name="nama_project" value="{{ old('nama_project', $find_id->nama_project) }}"
                        placeholder="Please fill in the item project name field ..." required>
                    @error('nama_project')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="sub_nama_project" class="form-label fw-semibold">Item project</label>
                    <input type="text" class="form-control @error('sub_nama_project') is-invalid @enderror"
                        id="sub_nama_project" name="sub_nama_project"
                        value="{{ old('sub_nama_project', $find_id->sub_nama_project) }}"
                        placeholder="Please fill in the item project name field ..." required>
                    @error('sub_nama_project')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kategori_project" class="form-label fw-semibold">Category Name Project</label>
                    <div class="mb-2">
                        <span class="text-muted small">Current Category</span>
                        <span class="badge bg-secondary">{{ $find_id->kategori_project ?? '-' }}</span>
                    </div>

                    <select class="form-select @error('kategori_project') is-invalid @enderror" name="kategori_project"
                        id="kategori_project" required>
                        <option value="" disabled
                            {{ old('kategori_project', $find_id->kategori_project) == '' ? 'selected' : '' }}>
                            -- Choosee Categories --
                        </option>
                        @foreach (['General Industry', 'Migas', 'Geothermal'] as $kategori)
                            <option value="{{ $kategori }}"
                                {{ old('kategori_project', $find_id->kategori_project) == $kategori ? 'selected' : '' }}>
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_project')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="no_jo_project" class="form-label fw-semibold">No. Jo (JOB Order) Project</label>
                        <input type="text" class="form-control @error('no_jo_project') is-invalid @enderror"
                            id="no_jo_project" name="no_jo_project"
                            value="{{ old('no_jo_project', $find_id->no_jo_project) }}"
                            placeholder="Please fill in the no jo (Job Order) project field ... " required>
                        @error('no_jo_project')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="no_po_project" class="form-label fw-semibold">No. PO(Purchase Order) Project</label>
                        <input type="text" class="form-control @error('no_po_project') is-invalid @enderror"
                            id="no_po_project" name="no_po_project"
                            value="{{ old('no_po_project', $find_id->no_po_project) }}"
                            placeholder="Please fill in the no po (Purchase Order) project field ... " required>
                        @error('no_po_project')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('project.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Save Data</button>
                </div>

            </form>
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
