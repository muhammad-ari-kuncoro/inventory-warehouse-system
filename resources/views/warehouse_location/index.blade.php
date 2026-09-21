@extends('layouts.dashboard-layout')

@section('container')
<div class="card shadow-sm">
    <div class="card-header bg-light py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Menu Warehouse</li>
            </ol>
        </nav>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <strong>{!! session()->get('success') !!}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif (session('delete'))
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        <strong>Data Has Been Deleted</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif (session('editSuccess'))
    <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
        <strong>{!! session()->get('editSuccess') !!}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                {{-- Area Filter jika diperlukan --}}
            </div>
            <div class="col-md-6 text-md-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#warehouseModal">
                    <i class="bx bx-plus"></i> Add Data
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle w-100" id="myTable7">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Warehouse Name</th>
                        <th>Type</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th style="width: 15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Dummy row / ganti dengan @foreach nanti --}}
                    <tr>
                        @foreach ($warehouse_location as $warehouse)
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $warehouse->name }}</td>
                        <td class="text-center">
                            <span
                                class="badge {{ ['raw_material' => 'bg-secondary', 'wip' => 'bg-warning text-dark', 'finished_goods' => 'bg-success'][$warehouse->type] ?? 'bg-light' }}">
                                {{ ucwords(str_replace('_', ' ', $warehouse->type)) }}
                            </span>
                        </td>
                        <td>{{ $warehouse->pic }}</td>
                        <td class="text-center">
                            <span class="badge {{ $warehouse->is_active ? 'bg-primary' : 'bg-danger' }}">
                                {{ $warehouse->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('warehouses.edit',$warehouse->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="bx bx-edit-alt"></i>
                                </a>
                                <a href="{{ route('warehouses.show', $warehouse->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                    <i class="bx bx-show"></i>
                                </a>
                                <form action="{{ route('warehouses.destroy',$warehouse->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Form Warehouse Location --}}
<div class="modal fade" id="warehouseModal" tabindex="-1" aria-labelledby="warehouseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warehouseModalLabel">Add Warehouse Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- Jangan lupa sesuaikan nama route-nya, gw asumsikan 'warehouse.store' --}}
            <form action="{{ route('warehouses.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- Input Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Warehouse Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" placeholder="e.g. Gudang Utama Plat" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Select Type (Enum) --}}
                    <div class="mb-3">
                        <label for="type" class="form-label">Warehouse Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option selected disabled value="">Choose Type...</option>
                            <option value="raw_material" {{ old('type') == 'raw_material' ? 'selected' : '' }}>Raw
                                Material</option>
                            <option value="wip" {{ old('type') == 'wip' ? 'selected' : '' }}>WIP (Work in Process)
                            </option>
                            <option value="finished_goods" {{ old('type') == 'finished_goods' ? 'selected' : '' }}>
                                Finished Goods</option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Address --}}
                    <div class="mb-3">
                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" rows="3" placeholder="Enter complete warehouse address..."
                            required>{{ old('address') }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        {{-- Input PIC --}}
                        <div class="col-md-6 mb-3">
                            <label for="pic" class="form-label">Person In Charge (PIC) <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pic') is-invalid @enderror" id="pic"
                                name="pic" value="{{ old('pic') }}" placeholder="Enter PIC name..." required>
                            @error('pic')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Is Active (Boolean) --}}
                        <div class="col-md-6 mb-3">
                            <label for="is_active" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('is_active') is-invalid @enderror" id="is_active"
                                name="is_active" required>
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            setTimeout(() => preloader.style.display = 'none', 500);
        }

        const dateElement = document.getElementById('currentDateTime');
        if (dateElement) {
            const updateDateTime = () => {
                const now = new Date();
                dateElement.textContent = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            };
            updateDateTime();
            setInterval(updateDateTime, 1000);
        }
    });

    $(document).ready(function () {
        $('#myTable7').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records..."
            }
        });
    });

</script>
@endpush
