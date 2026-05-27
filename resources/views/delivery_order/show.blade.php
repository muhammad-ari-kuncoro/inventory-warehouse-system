@extends('layouts.dashboard-layout')

@section('container')
    <div class="row">
        <div class="col-lg-12">

            {{-- Header Info Card --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary"><i class="bx bx-file"></i> Detail Delivery Order</h5>
                    <span class="badge bg-success"><i class="bx bx-check-circle"></i> {{ ucfirst($do->status ?? 'Active') }}</span>
                </div>
                <div class="card-body">
                    <div class="row text-dark">
                        <div class="col-md-3 border-end">
                            <small class="text-muted d-block">DO Number</small>
                            <strong class="text-primary">{{ $do->do_no ?? '-' }}</strong>
                        </div>
                        <div class="col-md-3 border-end">
                            <small class="text-muted d-block">Tanggal Pengiriman</small>
                            <strong>{{ $do->do_date ? \Carbon\Carbon::parse($do->do_date)->format('d-m-Y') : '-' }}</strong>
                        </div>
                        <div class="col-md-3 border-end">
                            <small class="text-muted d-block">Nama Project</small>
                            <strong>{{ optional($do->project)->nama_project ?? 'No Project' }}</strong>
                            @if ($do->project)
                                <span class="d-block text-muted"><small>{{ $do->project->sub_nama_project ?? '' }}</small></span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Alamat Penerima</small>
                            <strong>{{ $do->shipment_address ?? '-' }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- List Item Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-secondary"><i class="bx bx-list-ul"></i> List of Items</h5>
                    <span class="badge bg-secondary">{{ $do->details ? $do->details->count() : 0 }} Items</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle mb-0">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th style="width:5%">No</th>
                                    <th class="text-start">Deskripsi Item</th>
                                    <th style="width:15%">Ukuran</th>
                                    <th style="width:10%">Qty</th>
                                    <th style="width:10%">Berat (Kg)</th>
                                    <th style="width:10%">Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($do->details as $detail)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-start">{{ $detail->item_description ?? '-' }}</td>
                                        <td class="text-center">{{ $detail->item_size ?? '-' }}</td>
                                        <td class="text-center fw-bold text-success">{{ $detail->item_qty }}</td>
                                        <td class="text-center">{{ $detail->item_weight }}</td>
                                        <td class="text-center">{{ $detail->item_measurement }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class='bx bx-inbox me-1'></i> There are no items in this document.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light text-end">
                    <a href="{{ route('delivery-order.index') }}" class="btn btn-secondary px-4">
                        <i class="bx bx-arrow-back"></i> Back To List
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);
        });
    </script>
@endpush
