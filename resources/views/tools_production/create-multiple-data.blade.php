@extends('layouts.dashboard-layout')
@section('container')

<div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size: 13px;">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-primary">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('tools.index') }}" class="text-decoration-none text-primary">Tools</a>
            </li>
            <li class="breadcrumb-item active text-secondary">Add Multiple Data Tools</li>
        </ol>
    </nav>
</div>

<h5 class="fw-medium mb-4" style="font-size: 18px;">Add Multiple Data Tools</h5>

<form id="toolsForm">
    @csrf

    <div class="card border shadow-sm mb-3">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
                Tools Information
            </p>
        </div>
        <div class="card-body px-4 py-3">

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Tool Name</label>
                    <input type="text" class="form-control" id="nama_alat"
                        placeholder="Please fill in the Tools name field ...">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Specification Tool</label>
                    <input type="text" class="form-control" id="spesifikasi_alat"
                        placeholder="Please fill in the Specification Tool field ...">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Type Tools</label>
                    <select class="form-select select2-type-tools" id="jenis_alat">
                        <option value="">Select Type Tools</option>
                        <option value="Cutting Tools">Cutting Tools</option>
                        <option value="Lifting Tools">Lifting Tools</option>
                        <option value="Forming Tools">Forming Tools</option>
                        <option value="Fastener Tools">Fastener Tools</option>
                        <option value="Measuring Tools">Measuring Tools</option>
                        <option value="Tester Tools">Tester Tools</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Size Tools</label>
                    <select class="form-select select2-size-tools" id="tipe_alat">
                        <option value="">Select Size Tools</option>
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                    </select>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Quantity</label>
                    <input type="number" class="form-control" id="quantity" placeholder="0" min="1">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary" style="font-size: 11px;">Type Quantity</label>
                    <select class="form-select select2-type-qty" id="jenis_quantity">
                        <option value="">Select Type Quantity</option>
                        <option value="Unit">Unit</option>
                        <option value="Pcs">Pcs</option>
                        <option value="Set">Set</option>
                        <option value="Lot">Lot</option>
                        <option value="Pack">Pack</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="card-footer bg-transparent border-top px-4 py-3 d-flex justify-content-end">
            <button type="button" class="btn btn-primary btn-sm px-4" id="addToTable">
                <i class='bx bx-plus me-1'></i> Add to Table
            </button>
        </div>
    </div>

</form>

<div class="card border shadow-sm mb-4">
    <div class="card-header bg-transparent border-bottom py-3 px-4">
        <p class="mb-0 text-uppercase text-secondary" style="font-size: 13px; letter-spacing: 0.06em; font-weight: 500;">
            List Tools
        </p>
    </div>
    <div class="card-body px-4 py-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="toolsTable">
                <thead class="table-info text-center">
                    <tr>
                        <th>No</th>
                        <th>Tool Name</th>
                        <th>Specification</th>
                        <th>Type Tools</th>
                        <th>Size Tools</th>
                        <th>Quantity</th>
                        <th>Type Qty</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="emptyRow">
                        <td colspan="8" class="text-center text-muted py-3" style="font-size: 13px;">
                            No data yet. Fill the form above and click <strong>Add to Table</strong>.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex gap-2">
    <a href="{{ route('tools.index') }}" class="btn btn-light border px-4" style="font-size: 14px;">Cancel</a>
    <button type="button" id="submitAll" class="btn btn-primary px-4" style="font-size: 14px;">Save Data</button>
</div>

@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);
    });

    $(document).ready(function () {

        $('.select2-type-tools').select2({ theme: 'bootstrap-5', width: '100%', placeholder: 'Select Type Tools' });
        $('.select2-size-tools').select2({ theme: 'bootstrap-5', width: '100%', placeholder: 'Select Size Tools' });
        $('.select2-type-qty').select2({ theme: 'bootstrap-5', width: '100%', placeholder: 'Select Type Quantity' });

        let daftarTools = [];

        $('#addToTable').on('click', function () {
            const nama_alat        = $('#nama_alat').val().trim();
            const spesifikasi_alat = $('#spesifikasi_alat').val().trim();
            const jenis_alat       = $('#jenis_alat').val();
            const tipe_alat        = $('#tipe_alat').val();
            const quantity         = $('#quantity').val().trim();
            const jenis_quantity   = $('#jenis_quantity').val();

            if (!nama_alat || !spesifikasi_alat || !jenis_alat || !tipe_alat || !quantity || !jenis_quantity) {
                alert('Semua field wajib diisi!');
                return;
            }

            daftarTools.push({ nama_alat, spesifikasi_alat, jenis_alat, tipe_alat, quantity, jenis_quantity });
            renderTable();

            $('#nama_alat, #spesifikasi_alat, #quantity').val('');
            $('.select2-type-tools, .select2-size-tools, .select2-type-qty').val(null).trigger('change');
        });

        function renderTable() {
            const tbody = $('#toolsTable tbody');
            tbody.empty();

            if (daftarTools.length === 0) {
                tbody.append(`
                    <tr id="emptyRow">
                        <td colspan="8" class="text-center text-muted py-3" style="font-size: 13px;">
                            No data yet. Fill the form above and click <strong>Add to Table</strong>.
                        </td>
                    </tr>`);
                return;
            }

            daftarTools.forEach((t, i) => {
                tbody.append(`
                    <tr class="text-center">
                        <td>${i + 1}</td>
                        <td>${esc(t.nama_alat)}</td>
                        <td>${esc(t.spesifikasi_alat)}</td>
                        <td>${esc(t.jenis_alat)}</td>
                        <td>${esc(t.tipe_alat)}</td>
                        <td>${esc(t.quantity)}</td>
                        <td>${esc(t.jenis_quantity)}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="hapusItem(${i})">
                                <i class='bx bx-trash'></i>
                            </button>
                        </td>
                    </tr>`);
            });
        }

        window.hapusItem = function (index) {
            daftarTools.splice(index, 1);
            renderTable();
        };

        function esc(text) {
            if (text == null) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }

        $('#submitAll').on('click', async function () {
            if (daftarTools.length === 0) {
                alert('Tabel masih kosong! Tambahkan data terlebih dahulu.');
                return;
            }

            const csrfToken = $('input[name="_token"]').val();
            if (!csrfToken) {
                alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                return;
            }

            $(this).prop('disabled', true).text('Menyimpan...');

            try {
                const res = await fetch("{{ route('tools.store.multiple_data') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ data: daftarTools })
                });

                if (!res.ok) {
                    const text = await res.text();
                    let msg = 'Terjadi kesalahan. Cek console untuk detail.';
                    try { const json = JSON.parse(text); if (json.message) msg = json.message; } catch {}
                    alert(msg);
                    return;
                }

                const result = await res.json();
                alert(result.message ?? 'Data berhasil disimpan!');
                daftarTools = [];
                renderTable();

            } catch (err) {
                console.error(err);
                alert('Kesalahan jaringan. Cek console.');
            } finally {
                $(this).prop('disabled', false).text('Save Data');
            }
        });

    });
</script>
@endpush
