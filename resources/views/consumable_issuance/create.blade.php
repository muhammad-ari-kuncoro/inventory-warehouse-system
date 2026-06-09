@extends('layouts.dashboard-layout')

@section('container')
    <div class="card shadow-sm border-0">

        {{-- Header --}}
        <div class="card-header bg-white border-bottom pb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('consumable-issuance.index') }}">Consumable Out</a></li>
                    <li class="breadcrumb-item active">Form Pengambilan</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 fw-semibold">Form Pengambilan Consumable</h5>
                    <small class="text-muted">
                        Kode: <strong>{{ $header->kd_consumable_out }}</strong>
                        &nbsp;|&nbsp; Tanggal: {{ $header->transaction_date_out }}
                        &nbsp;|&nbsp;
                        <span class="badge bg-warning text-dark">Draft</span>
                    </small>
                </div>
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

                <div class="col-lg-5">
                    <div class="border rounded p-4 h-100">
                        <h6 class="fw-semibold mb-3">Tambah Item</h6>
                        <form action="{{ route('consumable-issuance.addItem', $header->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Nama Consumable <span
                                        class="text-danger">*</span></label>
                                <select name="consumable_id" class="form-select select-2" required>
                                    <option value="">-- Pilih Consumable --</option>
                                    @foreach ($consumables as $consumable)
                                        @if ($consumable->quantity <= 0)
                                            <option value="{{ $consumable->id }}" disabled class="text-danger">
                                                {{ $consumable->nama_consumable }} —
                                                {{ $consumable->spesifikasi_consumable }} (STOK HABIS)
                                            </option>
                                        @else
                                            <option value="{{ $consumable->id }}">
                                                {{ $consumable->nama_consumable }} —
                                                {{ $consumable->spesifikasi_consumable }} (Sisa: {{ $consumable->quantity }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('consumable_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Quantity <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="quantity" class="form-control" min="1"
                                    placeholder="Masukkan jumlah" required>
                                @error('quantity')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Tipe Quantity <span
                                        class="text-danger">*</span></label>
                                <select name="type_quantity" class="form-select select-2" required>
                                    <option value="">-- Pilih Satuan --</option>
                                    <option value="pcs">Pcs</option>
                                    <option value="kg">Kg</option>
                                    <option value="liter">Liter</option>
                                    <option value="meter">Meter</option>
                                    <option value="roll">Roll</option>
                                    <option value="box">Box</option>
                                    <option value="set">Set</option>
                                </select>
                                @error('type_quantity')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Keterangan</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Keterangan penggunaan (opsional)"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bx bx-plus me-1"></i> Tambah Item
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="border rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-semibold mb-0">Daftar Item ({{ $header->details->count() }})</h6>
                        </div>

                        @if ($header->details->isEmpty())
                            <div class="text-center text-muted py-5">
                                <i class="bx bx-box fs-1 d-block mb-2"></i>
                                Belum ada item. Tambahkan item di sebelah kiri.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Consumable</th>
                                            <th>Qty</th>
                                            <th>Satuan</th>
                                            <th>Keterangan</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($header->details as $detail)
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
                                                <td class="text-center">{{ $detail->type_quantity }}</td>
                                                <td>{{ $detail->description }}</td>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('consumable-issuance.removeItem', $detail->id) }}"
                                                        method="POST" onsubmit="return confirm('Hapus item ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        {{-- Info auto-submit --}}
                        <div class="alert alert-warning mt-3 mb-0 py-2 px-3" style="font-size:13px;">
                            <i class="bx bx-time-five me-1"></i>
                            Draft akan otomatis disubmit pada <strong>17:00</strong> jika belum disubmit manual.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('styles')
<style>
    .select2-container--bootstrap-5 .select2-results__option[aria-disabled=true] {
        color: #dc3545 !important;
        background-color: #f8d7da !important;
        font-weight: bold;
    }
</style>

@endpush
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            console.log('Preloader found. It will hide after 3 seconds...');
            setTimeout(function() {
                preloader.style.display = 'none';
                console.log('Preloader hidden.');
            }, 1500);
        } else {
            console.error('Preloader element not found!');
        }
    });
</script>

@push('scripts')
    <script>
        $('.select-2').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });
    </script>
@endpush
