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
                @if (isset($do) && $do->details?->count() > 0)
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <span class="fw-semibold text-muted small">Draft saved — not submitted yet</span>
                        <form action="{{ route('shipping-items.destroy', $do->id) }}" method="post" onsubmit="return confirm('Hapus draf ini?')">
                            @csrf
                            @method('DELETE')
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
                                    <i class='bx bx-map me-1'></i> Data Delivery
                                </h6>

                                <form action="{{ route('shipping-items.store') }}" method="post" id="formSubmit">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Date</label>
                                        <input type="date"
                                            class="form-control @error('date_delivery') is-invalid @enderror"
                                            name="date_delivery" value="{{ old('date_delivery') }}">
                                        @error('date_delivery')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Address</label>
                                        <textarea class="form-control @error('to') is-invalid @enderror" name="to" rows="3"
                                            placeholder="Please insert this field after you add the item unit ...">{{ old('to') }}</textarea>
                                        @error('to')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Description</label>
                                        <textarea class="form-control @error('description_stuff') is-invalid @enderror" name="description_stuff" rows="3"
                                            placeholder="Please insert this field after you add the item unit ...">{{ old('description_stuff') }}</textarea>
                                        @error('description_stuff')
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

                                <form action="{{ route('shipping-items.store.item') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Item Name</label>
                                        <input type="text" name="item_names"
                                            class="form-control @error('item_names') is-invalid @enderror"
                                            placeholder="Please Insert Item Name  ..." value="{{ old('item_names') }}">
                                        @error('item_names')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Quantity</label>
                                            <input type="number" name="quantity" min="1"
                                                class="form-control @error('quantity') is-invalid @enderror"
                                                placeholder="0" value="{{ old('quantity') }}">
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Type</label>
                                            <select class="form-select select-2 @error('quantity_type') is-invalid @enderror"
                                                name="quantity_type" data-placeholder="Choose Type Quantity">
                                                <option></option>
                                                @foreach(['Pcs', 'Unit', 'Set', 'Kg', 'Sheet', 'EA', 'Liter', 'Drum'] as $type)
                                                    <option value="{{ $type }}" {{ old('quantity_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                            @error('quantity_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Description Item</label>
                                        <textarea class="form-control @error('description_items') is-invalid @enderror" name="description_items" rows="3"
                                            placeholder="Please Insert Description Item Unit ...">{{ old('description_items') }}</textarea>
                                        @error('description_items')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('shipping-items.index') }}" class="btn btn-secondary btn-sm">
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
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($do) && $do->details?->count() > 0)
                                        @foreach ($do->details as $detail)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $detail->item_names ?? '-' }}</td>
                                                <td>{{ $detail->quantity ?? 0 }}</td>
                                                <td>{{ $detail->quantity_type ?? '-' }}</td>
                                                <td>{{ $detail->description_items ?? '-' }}</td>
                                                <td>
                                                    <form action="{{ route('shipping-items.item.delete', $detail->id) }}"
                                                        method="POST" class="d-inline" onsubmit="return confirm('Hapus item ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class='bx bx-trash'></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">
                                                <i class='bx bx-inbox me-1'></i> No Item Added yet
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if (isset($do) && $do->details?->count() > 0)
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) setTimeout(() => preloader.style.display = 'none', 1000);
        });

        $('.select-2').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: function() { return $(this).data('placeholder'); }
        });

        function submitForm() {
            $("#formSubmit").submit();
        }
    </script>
@endpush
