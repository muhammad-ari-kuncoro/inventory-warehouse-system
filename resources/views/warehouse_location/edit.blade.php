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
                        <a href="{{ route('warehouses.index') }}" class="text-primary text-decoration-none">Warehouse Location</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Data Warehouse</li>
                </ol>
            </nav>
        </div>

        <div class="card-body">
            <form action="{{ route('warehouses.update', $find_id->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Field: Name -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Warehouse Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $find_id->name) }}"
                        placeholder="Please fill in the warehouse name field ..." required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Field: Type -->
                <div class="mb-3">
                    <label for="type" class="form-label fw-semibold">Warehouse Type</label>
                    <select class="form-select @error('type') is-invalid @enderror" name="type" id="type" required>
                        <option value="" disabled>-- Choose Warehouse Type --</option>
                        <option value="raw_material" {{ old('type', $find_id->type) == 'raw_material' ? 'selected' : '' }}>Raw Material</option>
                        <option value="wip" {{ old('type', $find_id->type) == 'wip' ? 'selected' : '' }}>WIP (Work in Progress)</option>
                        <option value="finished_goods" {{ old('type', $find_id->type) == 'finished_goods' ? 'selected' : '' }}>Finished Goods</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Field: Address -->
                <div class="mb-3">
                    <label for="address" class="form-label fw-semibold">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                        name="address" rows="3" placeholder="Please fill in the warehouse address ..." required>{{ old('address', $find_id->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Field: PIC -->
                <div class="mb-3">
                    <label for="pic" class="form-label fw-semibold">PIC (Person in Charge)</label>
                    <input type="text" class="form-control @error('pic') is-invalid @enderror" id="pic"
                        name="pic" value="{{ old('pic', $find_id->pic) }}"
                        placeholder="Please fill in the PIC name field ..." required>
                    @error('pic')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Field: Is Active -->
                <div class="mb-4">
                    <label for="is_active" class="form-label fw-semibold">Status</label>
                    <select class="form-select @error('is_active') is-invalid @enderror" name="is_active" id="is_active" required>
                        <option value="1" {{ old('is_active', $find_id->is_active) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $find_id->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
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
