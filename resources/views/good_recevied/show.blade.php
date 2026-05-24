@extends('layouts.dashboard-layout')

@section('container')
    <div class="row">
        <div class="col-lg-12">

            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary"><i class="bx bx-file"></i> Detail Good Received</h5>

                    @if ($gr && $gr->status == 'draft')
                        <span class="badge bg-warning text-dark"><i class="bx bx-time-five"></i>Draft</span>
                    @else
                        <span class="badge bg-success"><i class="bx bx-check-circle"></i> Received</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row text-dark">
                        <div class="col-md-3 border-end">
                            <small class="text-muted d-block">Date Of Entry</small>
                            <strong>{{ $gr && $gr->tanggal_masuk ? \Carbon\Carbon::parse($gr->tanggal_masuk)->format('d-m-Y') : '-' }}</strong>
                        </div>
                        <div class="col-md-3 border-end">
                            <small class="text-muted d-block">Doc Good Received</small>
                            <strong class="text-primary">{{ $gr->kode_surat_jalan ?? '-' }}</strong>
                        </div>
                        <div class="col-md-3 border-end">
                            <small class="text-muted d-block">Name Supplier</small>
                            <strong>{{ $gr->nama_supplier ?? '-' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Name Project</small>
                            <strong>{{ optional($gr->project)->nama_project ?? 'No Project' }}</strong>
                            @if ($gr && $gr->project)
                                <span
                                    class="d-block text-muted"><small>{{ $gr->project->sub_nama_project ?? '' }}</small></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-secondary"><i class="bx bx-list-ul"></i> List of Items Received</h5>
                    <span class="badge bg-secondary">{{ $gr && $gr->details ? $gr->details->count() : 0 }} Items</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle mb-0">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th class="text-start">Name Item / Spesification</th>
                                    <th style="width: 15%">type Item</th>
                                    <th style="width: 15%">Quantity</th>
                                    <th class="text-start">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($gr && $gr->details && $gr->details->count() > 0)
                                    @foreach ($gr->details as $detail)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>

                                            <td class="text-start">
                                                <strong>
                                                    {{ optional($detail->material)->nama_material ??
                                                        (optional($detail->consumable)->nama_consumable ?? (optional($detail->machine)->nama_mesin ?? '-')) }}
                                                </strong>
                                                <span class="d-block text-muted" style="font-size: 0.85rem">
                                                    {{ optional($detail->material)->spesifikasi_material ??
                                                        (optional($detail->consumable)->spesifikasi_consumable ?? (optional($detail->machine)->spesifikasi_mesin ?? '')) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if ($detail->jenis_barang == 'Materials')
                                                    <span
                                                        class="badge bg-primary px-3 py-2 d-inline-flex align-items-center gap-1">
                                                        <i class="bx bx-cube-alt fs-6"></i> {{ $detail->jenis_barang }}
                                                    </span>
                                                @elseif($detail->jenis_barang == 'Consumables')
                                                    <span
                                                        class="badge bg-warning text-dark px-3 py-2 d-inline-flex align-items-center gap-1">
                                                        <i class="bx bx-test-tube fs-6"></i> {{ $detail->jenis_barang }}
                                                    </span>
                                                @elseif($detail->jenis_barang == 'Machines' || $detail->jenis_barang == 'Tools')
                                                    <span
                                                        class="badge bg-danger px-3 py-2 d-inline-flex align-items-center gap-1">
                                                        <i class="bx bx-cog fs-6"></i> {{ $detail->jenis_barang }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary px-3 py-2 d-inline-flex align-items-center gap-1">
                                                        <i class="bx bx-package fs-6"></i> {{ $detail->jenis_barang }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center fw-bold text-success">
                                                {{ $detail->quantity }} {{ $detail->quantity_jenis }}
                                            </td>
                                            <td class="text-start text-muted">
                                                <small>{{ $detail->keterangan_barang ?? '-' }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">There are no items in this
                                            document.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light text-end">
                    <a href="{{ route('good-received.index') }}" class="btn btn-secondary px-4">
                        <i class="bx bx-arrow-back"></i> Back To List
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);
        });
    </script>
@endpush
