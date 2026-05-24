@extends('layouts.dashboard-layout')

@push('styles')
<style>
    #div_machine,
    #div_consumable,
    #div_material {
        display: none;
    }
</style>
@endpush

@section('container')
<div class="row">
    <div class="col-lg-12">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{!! session()->get('success') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{!! session()->get('failed') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row g-4">

                    <div class="col-lg-6">
                        <div class="border rounded p-4 h-100">
                            <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="letter-spacing:.05em">
                                <i class='bx bx-file me-1'></i> Data Good Received
                            </h6>

                            <form action="{{ route('good-received.update', $gr->id) }}" method="post" id="formSubmit">
                                @csrf
                                @method('patch')

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Date Of Entry</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                        name="tanggal_masuk"
                                        value="{{ old('tanggal_masuk', $gr->tanggal_masuk) }}">
                                    @error('tanggal_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">No Document Good Received</label>
                                    <input type="text"
                                        class="form-control @error('kode_surat_jalan') is-invalid @enderror"
                                        name="kode_surat_jalan"
                                        value="{{ old('kode_surat_jalan', $gr->kode_surat_jalan) }}">
                                    @error('kode_surat_jalan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Name Supplier</label>
                                    <input type="text"
                                        class="form-control @error('nama_supplier') is-invalid @enderror"
                                        name="nama_supplier"
                                        value="{{ old('nama_supplier', $gr->nama_supplier) }}">
                                    @error('nama_supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Name Project</label>
                                    <select class="form-select select-2 @error('project_id') is-invalid @enderror"
                                        name="project_id" data-placeholder="Pilih salah satu">
                                        <option></option>
                                        @foreach ($data_project as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('project_id', $gr->project_id) == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama_project }} | {{ $data->sub_nama_project }} | NO JO : {{ $data->no_jo_project }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="border rounded p-4 h-100">
                            <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="letter-spacing:.05em">
                                <i class='bx bx-package me-1'></i> Data Item
                            </h6>

                            <form action="{{ route('good-received.store.item.update', $gr->id) }}" method="post">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Type Item Entry</label>
                                    <select name="jenis_barang" id="jenis_barang"
                                        class="form-select @error('jenis_barang') is-invalid @enderror">
                                        <option value="" selected disabled>-- Choose Type Item --</option>
                                        <option value="Materials">Materials</option>
                                        <option value="Consumables">Consumables</option>
                                        <option value="Machine">Machine</option>
                                    </select>
                                    @error('jenis_barang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" id="div_material">
                                    <label class="form-label fw-semibold">Name Material</label>
                                    <select name="material_id" class="form-select select-2" data-placeholder="Choose">
                                        <option></option>
                                        @foreach ($materials as $material)
                                            <option value="{{ $material->id }}">
                                                {{ $material->nama_material }} | {{ $material->spesifikasi_material }} |
                                                Stok: ({{ $material->quantity }}) {{ $material->jenis_quantity }} |
                                                {{ $material->project->nama_project }} | {{ $material->project->sub_nama_project }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3" id="div_consumable">
                                    <label class="form-label fw-semibold">Nama Consumable</label>
                                    <select name="consumable_id" class="form-select select-2" data-placeholder="Choose">
                                        <option></option>
                                        @foreach ($consumables as $consumable)
                                            <option value="{{ $consumable->id }}">
                                                {{ $consumable->nama_consumable }} | {{ $consumable->spesifikasi_consumable }} |
                                                Stok: ({{ $consumable->quantity }}) {{ $consumable->jenis_quantity }} |
                                                {{ $consumable->project->nama_project }} | {{ $consumable->project->sub_nama_project }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3" id="div_machine">
                                    <label class="form-label fw-semibold">Nama Machine</label>
                                    <select name="machine_id" class="form-select select-2" data-placeholder="Choose">
                                        <option></option>
                                        @foreach ($machines as $machine)
                                            <option value="{{ $machine->id }}">
                                                {{ $machine->nama_mesin }} | {{ $machine->spesifikasi_mesin }} |
                                                Stok: ({{ $machine->quantity }}) {{ $machine->jenis_quantity }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold">Quantity</label>
                                        <input type="number" min="1"
                                            class="form-control @error('quantity') is-invalid @enderror"
                                            name="quantity" placeholder="0">
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold">Type Quantity</label>
                                        <select class="form-select select-2 @error('quantity_jenis') is-invalid @enderror"
                                            name="quantity_jenis" data-placeholder="Pilih Satuan">
                                            <option></option>
                                            <option value="Pcs">Pcs</option>
                                            <option value="Unit">Unit</option>
                                            <option value="Set">Set</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Sheet">Sheet</option>
                                            <option value="EA">EA</option>
                                            <option value="Liter">Liter</option>
                                            <option value="Drum">Drum</option>
                                        </select>
                                        @error('quantity_jenis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Description Item</label>
                                    <textarea class="form-control" name="keterangan_barang" rows="3"
                                        placeholder="Opsional..."></textarea>
                                    @error('keterangan_barang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('good-received.index') }}" class="btn btn-secondary btn-sm">
                                        <i class='bx bx-arrow-back me-1'></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class='bx bx-plus me-1'></i> Add Item
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
                <div class="mt-4">
                    <hr>
                    <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="letter-spacing:.05em">
                        <i class='bx bx-list-ul me-1'></i> List Item
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Name Item</th>
                                    <th>Type Item</th>
                                    <th>Quantity</th>
                                    <th>Type Quantity</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($gr && $gr->details->count())
                                    @foreach ($gr->details as $detail)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ optional($detail->material)->nama_material
                                                    ?? optional($detail->consumable)->nama_consumable
                                                    ?? optional($detail->machine)->nama_mesin
                                                    ?? '-' }}
                                            </td>
                                            <td>{{ $detail->jenis_barang }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>{{ $detail->quantity_jenis }}</td>
                                            <td>{{ $detail->keterangan_barang ?? '-' }}</td>
                                            <td>
                                                <form action="{{ route('good-received.delete-detail', $detail->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Hapus item ini?')">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-3">
                                            <i class='bx bx-inbox me-1'></i> No items have been added yet
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if ($gr && $gr->details->count())
                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary" onclick="submitForm()">
                                <i class='bx bx-check me-1'></i> Submit
                            </button>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);
    });

    $('.select-2').select2({
        theme: "bootstrap-5",
        width: '100%',
        placeholder: $(this).data('placeholder'),
    });

    function submitForm() {
        $("#formSubmit").submit();
    }

    $(document).ready(function() {
        $('#jenis_barang').on('change', function() {
            var value = this.value;
            $('#div_material').toggle(value === 'Materials');
            $('#div_consumable').toggle(value === 'Consumables');
            $('#div_machine').toggle(value === 'Machine');
        });
    });
</script>
@endpush
