@extends('layouts.dashboard-layout')

@section('container')
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white border-bottom pb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('consumable-issuance.index') }}">Consumable Out</a></li>
                    <li class="breadcrumb-item active">Detail Pengambilan</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 fw-semibold">Detail Pengambilan Consumable</h5>
                    <small class="text-muted">
                        Kode: <strong>{{ $find_id->kd_consumable_out ?? '-' }}</strong>
                        &nbsp;|&nbsp; Tanggal: {{ $find_id->transaction_date_out }}
                        &nbsp;|&nbsp;
                        <span class="badge bg-success">{{ $find_id->status }}</span>
                    </small>
                </div>
                <a href="{{ route('consumable-issuance.index') }}" class="btn btn-sm btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3">
                <strong>{!! session('success') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif (session('delete'))
            <div class="alert alert-danger alert-dismissible fade show m-3">
                <strong>{!! session('delete') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card-body">
            <div class="row g-4">

                {{-- Kolom Kiri: Data Diri --}}
                <div class="col-lg-5">
                    <div class="border rounded p-4 h-100">
                        <h6 class="fw-semibold mb-3">Data Diri Pengambil</h6>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Tanggal Pengambilan</label>
                            <input type="text" class="form-control" value="{{ $find_id->transaction_date_out }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Bagian / Divisi</label>
                            <input type="text" class="form-control" value="{{ $find_id->user->posisi }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Nama Pengambil</label>
                            <input type="text" class="form-control" value="{{ $find_id->user->username }}" disabled>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Daftar Item --}}
                <div class="col-lg-7">
                    <div class="border rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-semibold mb-0">Daftar Item</h6>
                        </div>

                        @if (isset($find_id->details) && $find_id->details->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Consumable</th>
                                            <th>Qty</th>
                                            <th>Satuan</th>
                                            <th>Project</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($find_id->details as $detail)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>
                                                    <span
                                                        class="fw-semibold">{{ $detail->consumable->nama_consumable }}</span>
                                                    <br>
                                                    <small
                                                        class="text-muted">{{ $detail->consumable->spesifikasi_consumable }}</small>
                                                </td>
                                                <td class="text-center">{{ $detail->quantity }}</td>
                                                <td class="text-center">
                                                    {{ $detail->type_quantity ?? $detail->jenis_quantity }}</td>
                                                <td class="text-center">
                                                    <span>{{ $detail->consumable->project->nama_project ?? '-' }}</span>
                                                    @if (!empty($detail->project->sub_nama_project))
                                                        <br><small
                                                            class="text-muted">{{ $detail->project->sub_nama_project }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $detail->description ?? ($detail->keterangan_consumable ?? '-') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            {{-- Fallback: tampilan single item (model lama tanpa relasi details) --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Consumable</th>
                                            <th>Qty</th>
                                            <th>Satuan</th>
                                            <th>Project</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span
                                                    class="fw-semibold">{{ $find_id->consumable->nama_consumable }}</span>
                                                <br>
                                                <small
                                                    class="text-muted">{{ $find_id->consumable->spesifikasi_consumable }}</small>
                                            </td>
                                            <td class="text-center">{{ $find_id->quantity }}</td>
                                            <td class="text-center">{{ $find_id->jenis_quantity }}</td>
                                            <td>
                                                <span>{{ $find_id->project->nama_project ?? '-' }}</span>
                                                @if (!empty($find_id->project->sub_nama_project))
                                                    <br><small
                                                        class="text-muted">{{ $find_id->project->sub_nama_project }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $find_id->keterangan_consumable ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        {{-- Info Status --}}
                        <div class="alert alert-success mt-3 mb-0 py-2 px-3" style="font-size:13px;">
                            <i class="bx bx-check-circle me-1"></i>
                            Transaksi ini telah <strong>disubmit</strong> dan tercatat di sistem.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                setTimeout(function() {
                    preloader.style.display = 'none';
                }, 1500);
            }
        });
    </script>
@endpush
