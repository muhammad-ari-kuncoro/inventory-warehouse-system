@extends('layouts.dashboard-layout')

@push('styles')
    <style>
        #div_material,
        #div_consumable,
        #div_tool {
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
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">

                @if ($do_draft)
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <span class="fw-semibold text-muted small">Draft saved — not submitted yet</span>
                        <form action="{{ route('delivery-order.delete-draft') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class='bx bx-trash me-1'></i> Delete Draft
                            </button>
                        </form>
                    </div>
                @endif

                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded p-4 h-100">
                                <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="letter-spacing:.05em">
                                    <i class='bx bx-file me-1'></i> Data Delivery Order
                                </h6>

                                <form action="{{ route('delivery-order.store') }}" method="post" id="formSubmit">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Delivery Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control @error('tanggal_pengiriman') is-invalid @enderror"
                                            name="tanggal_pengiriman">
                                        @error('tanggal_pengiriman')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">No Packing List <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="packing_list"
                                            class="form-control @error('packing_list') is-invalid @enderror"
                                            placeholder="Please Insert Packing List Draft ...">
                                        @error('packing_list')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">No Delivery Order Document (DO NO) <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="delivery_order_no_doc"
                                            class="form-control @error('delivery_order_no_doc') is-invalid @enderror"
                                            placeholder="Please Insert Delivery Order Document ...">
                                        @error('delivery_order_no_doc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Address Recipient <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control @error('penerima') is-invalid @enderror" name="penerima" rows="3"
                                            placeholder="Please insert this field after you add the item unit ..."></textarea>
                                        @error('penerima')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Name Project <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select select-2 @error('project_id') is-invalid @enderror"
                                            name="project_id" data-placeholder="Choose The Project">
                                            <option></option>
                                            @foreach ($data_project as $data)
                                                <option value="{{ $data->id }}">
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

                        <div class="col-lg-6">
                            <div class="border rounded p-4 h-100">
                                <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="letter-spacing:.05em">
                                    <i class='bx bx-package me-1'></i> Data Item
                                </h6>

                                <form action="{{ route('delivery-order.store.item') }}" method="post">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Description Item Unit <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="item_description"
                                            class="form-control @error('item_description') is-invalid @enderror"
                                            placeholder="Please Insert Description Item Unit ...">
                                        @error('item_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Item / Unit Size <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="item_size"
                                            class="form-control @error('item_size') is-invalid @enderror"
                                            placeholder="Please Insert Size Item / Unit ...">
                                        @error('item_size')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row g-2 mb-3">

                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Quantity <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="item_qty" min="1"
                                                class="form-control @error('item_qty') is-invalid @enderror"
                                                placeholder="0">
                                            @error('item_qty')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Weight (Kg) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="item_weight" step="0.01" min="0"
                                                class="form-control @error('item_weight') is-invalid @enderror"
                                                placeholder="0.00">
                                            @error('item_weight')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Type Quantity<span
                                                class="text-danger">*</span></label>
                                        <select class="form-select select-2 @error('satuan_barang') is-invalid @enderror"
                                            name="satuan_barang" data-placeholder="Choose Item Unit">
                                            <option></option>
                                            <option value="Pcs">Pcs</option>
                                            <option value="Unit">Unit</option>
                                            <option value="Set">Set</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Sheet">Sheet</option>
                                            <option value="EA">EA</option>
                                            <option value="Liter">Liter</option>
                                            <option value="Drum">Drum</option>
                                            <option value="Meter">Meter</option>
                                            <option value="Box">Box</option>
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

                    <div class="mt-4">
                        <hr>
                        <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="letter-spacing:.05em">
                            <i class='bx bx-list-ul me-1'></i> List Item (Draft)
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Description</th>
                                        <th>Item Size</th>
                                        <th>Qty</th>
                                        <th>Weight (Kg)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($do_draft && $do_draft->details->count())
                                        @foreach ($do_draft->details as $detail)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $detail->item_description }}</td>
                                                <td>{{ $detail->item_size }}</td>
                                                <td>{{ $detail->item_qty }} {{ $detail->item_measurement }}</td>
                                                <td>{{ $detail->item_weight }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="{{ route('delivery-order.edit-detail-item', $detail->id) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i class='bx bx-edit-alt'></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('delivery-order.delete-per-draft', $detail->id) }}"
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
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3">
                                                <i class='bx bx-inbox me-1'></i> No Item Added yet
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if ($do_draft && $do_draft->details->count())
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-primary" onclick="submitForm()">
                                    <i class='bx bx-check me-1'></i> Submit DO
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
    </script>
@endpush
