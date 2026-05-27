@extends('layouts.dashboard-layout')

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

                    {{-- LEFT: Data DO --}}
                    <div class="col-lg-6">
                        <div class="border rounded p-4 h-100">
                            <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="letter-spacing:.05em">
                                <i class='bx bx-file me-1'></i> Data Delivery Order
                            </h6>

                            <form action="{{ route('delivery-order.update', $do->id) }}" method="post" id="formSubmit">
                                @csrf
                                @method('PATCH')

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Delivery Order Number</label>
                                    <input type="text" class="form-control" value="{{ $do->do_no }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal Pengiriman</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_pengiriman') is-invalid @enderror"
                                        name="tanggal_pengiriman" value="{{ $do->do_date }}">
                                    @error('tanggal_pengiriman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Alamat Penerima</label>
                                    <textarea class="form-control @error('penerima') is-invalid @enderror"
                                        name="penerima" rows="3">{{ $do->shipment_address }}</textarea>
                                    @error('penerima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama Project</label>
                                    <select class="form-select select-2 @error('project_id') is-invalid @enderror"
                                        name="project_id" data-placeholder="Pilih Salah Satu">
                                        <option></option>
                                        @foreach ($data_project as $data)
                                            <option value="{{ $data->id }}" {{ $do->project_id == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama_project }} | {{ $data->sub_nama_project }}
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

                    {{-- RIGHT: Form Tambah Item --}}
                    <div class="col-lg-6">
                        <div class="border rounded p-4 h-100">
                            <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="letter-spacing:.05em">
                                <i class='bx bx-package me-1'></i> Tambah Item
                            </h6>

                            <form action="{{ route('delivery-order.store.item') }}" method="post">
                                @csrf
                                <input type="hidden" name="do_id" value="{{ $do->id }}">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Deskripsi Barang</label>
                                    <input type="text" name="item_description"
                                        class="form-control @error('item_description') is-invalid @enderror"
                                        placeholder="Masukkan deskripsi barang">
                                    @error('item_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Ukuran Barang</label>
                                    <input type="text" name="item_size"
                                        class="form-control @error('item_size') is-invalid @enderror"
                                        placeholder="123 X 123 X 123">
                                    @error('item_size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold">Jumlah</label>
                                        <input type="number" name="item_qty" min="1"
                                            class="form-control @error('item_qty') is-invalid @enderror"
                                            placeholder="0">
                                        @error('item_qty')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold">Berat (Kg)</label>
                                        <input type="number" name="item_weight" step="0.01" min="0"
                                            class="form-control @error('item_weight') is-invalid @enderror"
                                            placeholder="0.00">
                                        @error('item_weight')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Satuan</label>
                                    <select class="form-select select-2 @error('satuan_barang') is-invalid @enderror"
                                        name="satuan_barang" data-placeholder="Pilih Satuan">
                                        <option></option>
                                        <option value="Pcs">Pcs</option>
                                        <option value="Unit">Unit</option>
                                        <option value="Set">Set</option>
                                        <option value="Kg">Kg</option>
                                        <option value="Lembar">Lembar</option>
                                        <option value="EA">EA</option>
                                        <option value="Liter">Liter</option>
                                        <option value="Drum">Drum</option>
                                        <option value="MTR">MTR</option>
                                        <option value="BOX">BOX</option>
                                    </select>
                                    @error('satuan_barang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('delivery-order.index') }}" class="btn btn-secondary btn-sm">
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

                {{-- List Item --}}
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
                                    <th>Deskripsi</th>
                                    <th>Ukuran</th>
                                    <th>Qty</th>
                                    <th>Berat (Kg)</th>
                                    <th>Satuan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($do->details as $detail)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->item_description }}</td>
                                        <td>{{ $detail->item_size }}</td>
                                        <td>{{ $detail->item_qty }}</td>
                                        <td>{{ $detail->item_weight }}</td>
                                        <td>{{ $detail->item_measurement }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('delivery-order.detail-updating', $detail->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class='bx bx-edit-alt'></i>
                                                </a>
                                                <form action="{{ route('delivery-order.delete-per-draft', $detail->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Hapus item ini?')">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-3">
                                            <i class='bx bx-inbox me-1'></i> No Item Added yet
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-primary" onclick="submitForm()">
                            <i class='bx bx-check me-1'></i> Update DO
                        </button>
                    </div>
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
</script>
@endpush
